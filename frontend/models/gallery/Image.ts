export default class Image{
    id:number|null;
    filename:string;
    mime:string;
    path:string;
    size:number;
    constructor(){
        this.id=null;
        this.filename='';
        this.mime='';
        this.path='';
        this.size=0;
    }
}