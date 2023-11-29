import GetCategories from '../category/GetCategories';
export class CreateUser{
    name: string;
    cpf_cnpj: string;
    email: string;
    password: string;
    birth: string;
    categories:GetCategories[]|null;
    constructor() {
        this.name = "";
        this.cpf_cnpj = "";
        this.email = "";
        this.password = "";
        this.birth = '';
        this.categories = null;
    }

}

export type AuthToken = {
    access_token: string;
    token_type: string,
    expires_in: number,
    expiration_time: string
}

export class OwnerUser{
    id:number;
    name: string;
    cpf_cnpj: string;
    email: string;
    password: string;
    birth: string;
    categories:GetCategories[]|null;
    constructor() {
        this.id = 0;
        this.name = "";
        this.cpf_cnpj = "";
        this.email = "";
        this.password = "";
        this.birth = '';
        this.categories = null;
    }

}

export class UpdateUser{
    name: string;
    cpf_cnpj: string;
    email: string;
    password: string;
    birth: string;
    categories:GetCategories[]|null;
    constructor() {
        this.name = "";
        this.cpf_cnpj = "";
        this.email = "";
        this.password = "";
        this.birth = '';
        this.categories = null;
    }

}