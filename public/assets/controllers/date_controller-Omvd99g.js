import { Controller } from "@hotwired/stimulus";

export default class extends Controller{
    static values = {
        date : String
    }
    connect(){

        this.element.innerText = this.decodeDate();
    }

    decodeDate(){
        let date= new Date(`${this.dateValue}Z`.replace(' ','T'));
        return `${date.getDate().toString().padStart(2,"0")}/${(date.getMonth()+1).toString().padStart(2,"0")}/${date.getFullYear().toString()} - ${date.getHours().toString().padStart(2,"0")}:${date.getMinutes().toString().padStart(2,"0")}`;
    }
}