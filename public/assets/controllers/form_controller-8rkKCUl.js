import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
    static targets = ['input','output'];
    
    changeFileValue(){
        if(this.inputTarget.files.length){
            this.outputTarget.innerText = this.inputTarget.files[0].name ;
        }
    }
}