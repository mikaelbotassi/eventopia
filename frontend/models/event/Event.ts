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
    title:string;
    event_date:string;
    localization:string;
    description:string;

    constructor(){
        this.title = '';
        this.event_date = '';
        this.localization = '';
        this.description = '';
    }
}