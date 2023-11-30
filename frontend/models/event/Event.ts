import { OwnerUser } from "../user/User";
import GetCategories from '../category/GetCategories';

export class CreateEvent{
    title:string;
    event_date:string;
    localization:string;
    urlLocalization:string;
    description:string;
    workload:number;
    registration_validity:string;
    categories:GetCategories[]|null;

    constructor(){
        this.title = '';
        this.event_date = '';
        this.localization = '';
        this.urlLocalization = '';
        this.description = '';
        this.workload = 0;
        this.registration_validity = '';
        this.categories = null;
    }
}

export class ListEvent{
    id:number|null;
    title:string;
    event_date:string;
    localization:string;
    description:string;
    categories:GetCategories[]|null;

    constructor(){
        this.id = null;
        this.title = '';
        this.event_date = '';
        this.localization = '';
        this.description = '';
        this.categories = null;
    }
}

export class OneEvent{
    id:number|null;
    title:string;
    event_date:string;
    localization:string;
    description:string;
    ownerObj:OwnerUser;
    categories:GetCategories[]|null;

    constructor(){
        this.id = null;
        this.title = '';
        this.event_date = '';
        this.localization = '';
        this.description = '';
        this.ownerObj = new OwnerUser();
        this.categories = null;
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
    categories:GetCategories[]|null;
    constructor(){
        this.title = '';
        this.event_date = '';
        this.urlLocalization = '';
        this.localization = '';
        this.description = '';
        this.workload = 0;
        this.registration_validity = '';
        this.categories = null;
    }
}