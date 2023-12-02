<?php

namespace App\Models;

use App\Utils\Functions;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Utils\Database\EloquentFindable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Response;

/**
 * @property int id
 * @property int user_id
 * @property int event_id
 * @property User user
 * @property Event event
 * @property string presence_date
 * @method static where(string $string, int|string|null $id)
 */

class Registration extends Model
{
    protected $table = "registrations";
    use EloquentFindable;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $with = ['user', 'event'];

    public function user():BelongsTo{
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function event():BelongsTo{
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }

    public static function exportCsv(array|Collection $registrations): \Illuminate\Http\Response
    {
        $csvFileName = 'registrations.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $csvFileName . '"',
        ];
        $handle = fopen('php://output', 'w');
        fputcsv($handle, ['Nome Completo', 'Data de Nascimento', 'CPF',
            'E-mail', 'Carga Horária', 'Início da Participação', 'Término da Participação']); // Add more headers as needed

        foreach ($registrations as $registration) {
            fputcsv($handle, [
                $registration->user->name ,
                Carbon::parse($registration->user->birth)->format('d/m/Y'),
                Functions::onlyNumbers($registration->user->cpf_cnpj),
                $registration->user->email,
                Functions::onlyNumbers($registration->event->workload),
                ($registration->presence_date != '' ?
                    Carbon::parse($registration->presence_date)->format('d/m/Y') :
                    ''
                ),
                Carbon::parse($registration->event->event_date)->format('d/m/Y'),
            ]);
        }

        fclose($handle);

        return Response::make('', 200, $headers);
    }

}
