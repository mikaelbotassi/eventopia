import type GetRegistration from "../registration/GetRegistration";

export default class GeCertificate{
    id:number|string|null;
    registration:GetRegistration|null;
    code:string|null;
    created_at:string

    constructor(){
        this.id = null;
        this.registration = null;
        this.code = null;
        this.created_at='';
    }

}