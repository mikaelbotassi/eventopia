import type { OneEvent } from "../event/Event";
import type { OwnerUser } from "../user/User";

export default class GetRegistration{
    id:string|number|null
    user:OwnerUser|null;
    event:OneEvent|null;
    presence_date:string;
    created_at:string;

    constructor(){
        this.id = null;
        this.user = null;
        this.event = null;
        this.presence_date = '';
        this.created_at = '';
    }

}