import {OwnerUser} from '../user/User';
import {OneEvent} from '../event/Event';

export default class GetFeedbacks{
    id:string|number;
    author:OwnerUser;
    description:string;
    event:OneEvent;
    created_at:string;

    constructor(){
        this.id = 0;
        this.author = new OwnerUser();
        this.event = new OneEvent();
        this.description = '';
        this.created_at = '';
    }
}