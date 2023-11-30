<?php

namespace App\Services;

use App\DTO\DTO;
use App\DTO\Registration\RegistrationDTO;
use App\Models\Event;
use App\Models\Registration;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class RegistrationService
{
    public function getAll(DTO $dtoClass,Collection $filters = new Collection()):Collection{
        $query = Registration::query();

        foreach ($filters as $column => $value){
            $query->where($column, $value);
        }

        return $dtoClass::toDTOs($query->get());

    }

    public function findById(int $id):DTO{
        return RegistrationDTO::toDTO(Registration::findByOrFail($id));
    }

    /**
     * @throws Exception
     */
    public function create(DTO $objDto):bool{
        $obj = new Registration();
        $arr = $objDto->toArray();

        if(!Event::where('id', $arr['event_id'])->exists())
            throw new Exception("Evento não encontrado", 404);

        if(Event::where('id', $arr['event_id'])
            ->where('registration_validity', '<', now())->exists()
        )
            throw new Exception("Parece que você extrapolou a data limite de inscrição.
            Por este motivo não foi possível confirmar sua inscrição", 406);

        if(Registration::where('event_id', $arr['event_id'])
            ->where('user_id', auth()->id())->exists()
        )
            throw new Exception("Você já está inscrito neste evento.", 409);

        foreach ($arr as $name => $value)
            if($value != null) $obj->$name = $value;
        $obj->user_id = auth()->id();
        return $obj->save();
    }

    public function update(DTO $objDto, int $id):bool{
        $obj = Registration::findByOrFail($id);
        $arr = $objDto->toArray();
        foreach ($arr as $name => $value)
            if($value != null) $obj->$name = $value;
        return $obj->save();
    }

    /**
     * @throws Exception
     */
    public function delete(int $id):bool{
        $obj = Registration::findByOrFail($id);
        if($obj->user_id != auth()->id() || Event::findByOrFail($obj->event_id)->owner != auth()->id())
            throw new Exception("You do not have privileges to perform this action");
        return $obj->delete();
    }

    /**
     * @throws Exception
     */
    public function getQrCodeByEvent(int $registration_id):string
    {
        if(!Registration::where('id',$registration_id)->exists())
            throw new Exception("Inscrição não encontrada", 404);

        $registration = Registration::findByOrFail($registration_id);

        $data = [
            'registration_id' => $registration->id,
            'user_name' => $registration->user->name,
            'event_title' => $registration->event->title,
//            'validity' => Carbon::now()->addHours(24)->toDateTimeString(),
            'created_at' => now()
        ];

        $json = json_encode($data);

        return Crypt::encryptString($json);

    }

    /**
     * @throws Exception
     */
    public function confirmPresence(string $qrCode):bool
    {
        $obj = json_decode(Crypt::decryptString($qrCode));

        $registration = Registration::findByOrFail($obj->registration_id);

        if($registration->event->owner != auth()->id())
            throw new Exception("Você não possui autorização para realizar esta operação", 403);

        if($registration->event->event_date > now())
            throw new Exception("Não é possível definir presença antes do evento.", 403);

        $registration->presence_date = now();
        $registration->save();
        return true;
    }

    public function getAllWithFilter(array $filters):Collection{
        $query = Registration::query();

        foreach ($filters as $filter){
            $query->where($filter['column'],$filter['operator'],$filter['value']);
        }

        return RegistrationDTO::toDTOs($query->get());

    }

    public function getAllByAuthId(): Collection
    {
        $query = Registration::query();
        $query->join('users', 'registrations.user_id', '=', 'users.id')
        ->join('events', 'events.id', '=', 'registrations.event_id')
        ->select('registrations.*')
        ->where('users.id', auth()->id())
        ->orderBy('events.event_date')
        ->get();
        return RegistrationDTO::toDTOs($query->get());
    }

}
