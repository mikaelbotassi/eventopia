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
            throw new Exception("Event not found", 404);

        if(!Event::where('id', $arr['event_id'])
            ->where('registration_validity', '<', now())->exists()
        )
            throw new Exception("The registration deadline for the event has expired", 406);

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
        if($obj->user_id != auth()->id() || Event::findByOrFail('id', $obj->event_id)->owner != auth()->id())
            throw new Exception("You do not have privileges to perform this action");
        return $obj->delete();
    }

    /**
     * @throws Exception
     */
    public function getQrCodeByEvent(int $event_id):string
    {
        if(!Event::where('id',$event_id)->exists())
            throw new Exception("Event not found", 404);

        if(!Event::where('id',$event_id)->where('owner', auth()->id())->exists())
            throw new Exception("You have no control over the requested event", 405);

        $data = [
            'event_id' => $event_id,
            'validity' => Carbon::now()->addHours(24)->toDateTimeString(),
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
        if(now() > $obj->validity)
            throw new Exception("Unable to complete your action because the QrCode has expired", 406);

        if($registration = Registration::where('user_id', auth()->id())->where('event_id', $obj->event_id)->first()){
            $registration->is_present = true;
            $registration->save();
            return true;
        }
        return false;
    }

}
