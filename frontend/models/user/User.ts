export class CreateUser{
    name: string;
    email: string;
    password: string;
    birth: string;
    constructor() {
        this.name = "";
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