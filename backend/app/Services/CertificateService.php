<?php

namespace App\Services;

use App\DTO\Certificate\CertificateDTO;
use App\DTO\DTO;
use App\Models\Certificate;
use App\Models\Event;
use App\Models\Registration;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Crypt;

class CertificateService
{
    public function getAll(DTO $dtoClass,Collection $filters = new Collection()):Collection{
        $query = Certificate::query();

        foreach ($filters as $column => $value){
            $query->where($column, $value);
        }

        return $dtoClass::toDTOs($query->get());

    }

    public function getByCode(string $code): DTO
    {
        return CertificateDTO::toDTO(Certificate::findByOrFail($code, 'code'));
    }

    public function getAllWithFilter(array $filters):Collection{
        $query = Certificate::query();

        foreach ($filters as $filter){
            $query->where($filter['column'],$filter['operator'],$filter['value']);
        }

        return CertificateDTO::toDTOs($query->get());

    }

    public function findById(int $id):DTO{
        return CertificateDTO::toDTO(Certificate::findByOrFail($id));
    }

    public function getAllByAuthId(): Collection
    {
        $query = Certificate::query();
        $query->whereIn('registration_id', function ($query) {
            $query->select('id')
                ->from('registrations')
                ->where('user_id', auth()->id());
        });
        return CertificateDTO::toDTOs($query->get());
    }

    /**
     * @throws Exception
     */
    public function create(DTO $objDto):bool{
        $obj = new Certificate();
        $arr = $objDto->toArray();

        if(!Event::where('id', $arr['event_id'])->exists())
            throw new Exception("Event not found", 404);

        if(!User::where('id', $arr['user_id'])->exists())
            throw new Exception("User not found", 404);

        if(!Registration::where('user_id', $arr['user_id'])
            ->where('event_id', $arr['event_id'])
            ->exists()
        )
            throw new Exception("This user is not registered for the selected event", 404);

        foreach ($arr as $name => $value)
            if($value != null) $obj->$name = $value;
        return $obj->save();
    }

    /**
     * @throws Exception
     */
    public function delete(int $id):bool{
        $obj = Certificate::findByOrFail($id);
        if($obj->registration->user_id != auth()->id() || Event::findByOrFail('id', ($obj->registration->event->owner != auth()->id())))
            throw new Exception("You do not have privileges to perform this action");
        return $obj->delete();
    }

}
