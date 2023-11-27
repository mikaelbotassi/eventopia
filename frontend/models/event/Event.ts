import { OwnerUser } from "../user/User";

export class CreateEvent{
    title:string;
    event_date:string;
    localization:string;
    urlLocalization:string;
    description:string;
    workload:number;
    registration_validity:string;

    constructor(){
        this.title = '';
        this.event_date = '';
        this.localization = '';
        this.urlLocalization = '';
        this.description = '';
        this.workload = 0;
        this.registration_validity = '';
    }
}

export class ListEvent{
    id:number|null;
    title:string;
    event_date:string;
    localization:string;
    description:string;

    constructor(){
        this.id = null;
        this.title = '';
        this.event_date = '';
        this.localization = '';
        this.description = '';
    }
}

export class OneEvent{
    id:number|null;
    title:string;
    event_date:string;
    localization:string;
    description:string;
    ownerObj:OwnerUser;

    constructor(){
        this.id = null;
        this.title = '';
        this.event_date = '';
        this.localization = '';
        this.description = '';
        this.ownerObj = new OwnerUser();
    }
}

export class UpdateEvent{
    title:string;
    event_date:string;
    localization:string;
    urlLocalization:string;
    description:string;
    workload:number;
    registration_validity:string;

    constructor(){
        this.title = '';
        this.event_date = '';
        this.urlLocalization = '';
        this.localization = '';
        this.description = '';
        this.workload = 0;
        this.registration_validity = '';
    }
}