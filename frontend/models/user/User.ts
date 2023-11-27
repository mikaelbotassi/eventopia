export class CreateUser{
    name: string;
    cpf_cnpj: string;
    email: string;
    password: string;
    birth: string;
    constructor() {
        this.name = "";
        this.cpf_cnpj = "";
        this.email = "";
        this.password = "";
        this.birth = '';
    }

}

export type AuthToken = {
    access_token: string;
    token_type: string,
    expires_in: number,
    expiration_time: string
}