import { Controller } from "@hotwired/stimulus";
import QRCode from 'qrcode';

export default class extends Controller {

    async openModal() {
        let modalContainer = document.getElementById("modalContainer");
        let modalRadioInfo = modalContainer.querySelector('#modalRadioInfo');
        let modalRadioParrainage = modalContainer.querySelector("#modalRadioParrainage");
        let modalRadioTransaction = modalContainer.querySelector("#modalRadioTransaction");
        modalRadioInfo.removeAttribute('loaded');
        modalRadioParrainage.removeAttribute('loaded');
        modalRadioTransaction.removeAttribute('loaded');
        modalRadioInfo.control.checked = true;



        modalContainer.setAttribute('Userid', this.element.cells[0].innerText);

        this.loadInfo();

        modalContainer.classList.remove('hidden');
    }


    getSikla(data) {
        /////////////////////////////////////////////
        //
        //    //  RIGHT  //       //  LEFT  //
        //       1  1  1            1  1  1
        //       R  r  l            R  r  l       
        //
        /////////////////////////////////////////////



        // INITIALISER SIKLA ETAT EN 0
        let sikla_etats = 0;


        // SI IL Y A DES FILLEULS
        for (let i = 0; i < Math.min(2, data.enfants.length); i++) {

            sikla_etats <<= 1;
            sikla_etats |= 1;
            sikla_etats <<= 2;
            if (data.enfants[i].indirect > 0) {
                sikla_etats |= Math.min(2, data.enfants[i].indirect) * 2 - 1;
            }

        }

        console.log(sikla_etats.toString(2));
        return sikla_etats;
    }


    async loadInfo() {
        let modalContainer = document.getElementById("modalContainer");

        let modalRadioInfo = modalContainer.querySelector('#modalRadioInfo');
        let modalRadioParrainage = modalContainer.querySelector("#modalRadioParrainage");
        let modalRadioTransaction = modalContainer.querySelector("#modalRadioTransaction");
        
        
        modalRadioInfo.setAttribute('active','');
        modalRadioParrainage.removeAttribute('active');
        modalRadioTransaction.removeAttribute('active');


        if (!(modalRadioInfo.getAttribute("loaded"))) {
            let modalName = modalContainer.querySelector('#modalName');
            let modalCode = modalContainer.querySelector('#modalCode');
            let modalParent = modalContainer.querySelector("#modalParent");
            let modalMembre = modalContainer.querySelector("#modalMembre");
            let modalParraine = modalContainer.querySelector("#modalParraine");
            let modalCotisant = modalContainer.querySelector("#modalCotisant");
            let modalEmail = modalContainer.querySelector("#modalEmail");
            let modalTelephone = modalContainer.querySelector("#modalTelephone");
            let modalDate = modalContainer.querySelector("#modalDate");
            let modalPortefeuille = modalContainer.querySelector("#modalPortefeuille");
            let modalQRCode = modalContainer.querySelector("#modalQRCode");

            
            modalName.innerText = this.element.cells[1].innerText;
            modalCode.innerText = this.element.cells[3].innerText;
            modalEmail.innerText = this.element.cells[2].innerText;
            modalTelephone.innerText = this.element.cells[5].innerText;
            modalDate.innerText = this.element.cells[10].innerText;
            
            let result = await fetch(`${document.getElementById('apiGetUser').value}/${modalContainer.getAttribute('Userid')}`)
            .then(res => res.json());
            modalParent.innerText = result[0].parent ?? '-';
            modalMembre.innerText = result[0].membre ? 'Oui' : 'Non';
            modalParraine.innerText = result[0].parraine ?? 0;
            modalCotisant.innerText = result[0].cotisant ? 'Oui' : 'Non';
            modalPortefeuille.innerText = result[0].solde;
            let binarySikla = this.getSikla(result);
            let modalSiklaCenter = modalContainer.querySelector('#modalSiklaCenter');
            let modalSiklaInner = modalContainer.querySelector('#modalSiklaInner');
            let modalSiklaOuter = modalContainer.querySelector('#modalSiklaOuter');
            if (result[0].cotisant) {
                modalSiklaCenter.classList.add('bg-yellow-500');
            }
            else {
                modalSiklaCenter.classList.remove('bg-yellow-500');
            }
            if (binarySikla & 4) {
                modalSiklaInner.children[0].classList.add('bg-green-600');
            }
            else {
                modalSiklaInner.children[0].classList.remove('bg-green-600');
            }
            if (binarySikla & 2) {
                modalSiklaOuter.children[0].classList.add('bg-green-600');
            }
            else {
                modalSiklaOuter.children[0].classList.remove('bg-green-600');
            }
            if (binarySikla & 1) {
                modalSiklaOuter.children[1].classList.add('bg-green-400');
            }
            else {
                modalSiklaOuter.children[1].classList.remove('bg-green-400');
            }
            if (binarySikla & 32) {
                modalSiklaInner.children[1].classList.add('bg-green-400');
            }
            else {
                modalSiklaInner.children[1].classList.remove('bg-green-400');
            }
            if (binarySikla & 16) {
                modalSiklaOuter.children[2].classList.add('bg-green-400');
            }
            else {
                modalSiklaOuter.children[2].classList.remove('bg-green-400');
            }
            if (binarySikla & 8) {
                modalSiklaOuter.children[3].classList.add('bg-green-600');
            }
            else {
                modalSiklaOuter.children[3].classList.remove('bg-green-600');
            }
            
            QRCode.toDataURL(this.element.cells[3].innerText)
            .then(dataUrl => {modalQRCode.src = dataUrl});
            let modalDirect = modalContainer.querySelector('#modalDirect');
            let modalIndirect = modalContainer.querySelector('#modalIndirect');

            modalDirect.innerText = result.enfants.length;
            modalIndirect.innerText = result.enfants.reduce((prev, curr) => prev + curr.indirect, 0);

            modalRadioInfo.setAttribute('loaded', '1');

        }
    }

    async loadParrainage() {
        let modalContainer = document.getElementById("modalContainer");
        let modalRadioInfo = modalContainer.querySelector('#modalRadioInfo');
        let modalRadioParrainage = modalContainer.querySelector("#modalRadioParrainage");
        let modalRadioTransaction = modalContainer.querySelector("#modalRadioTransaction");
        modalRadioInfo.removeAttribute('active');
        modalRadioParrainage.setAttribute('active','');
        modalRadioTransaction.removeAttribute('active');

        if (!(modalRadioParrainage.getAttribute('loaded'))) {

            let modalTableParrainage = modalContainer.querySelector("#modalTableParrainage");
            modalTableParrainage.innerHTML = "";

            let result = await fetch(`${document.getElementById('apiGetParrainage').value}/${modalContainer.getAttribute('Userid')}`)
                .then(res => res.json());


            for (let datas of result) {
                modalTableParrainage.innerHTML += `
                    <tr>
						<td class="border border-teal-950 p-2">${this.decodeDate(datas.date)}</td>
						<td class="border border-teal-950 p-2">${datas.nom}</td>
					</tr>
                `;
            }

            modalRadioParrainage.setAttribute('loaded', '1');


        }

    }


    async loadTransaction() {
        let modalContainer = document.getElementById("modalContainer");
        let modalRadioInfo = modalContainer.querySelector('#modalRadioInfo');
        let modalRadioParrainage = modalContainer.querySelector("#modalRadioParrainage");
        let modalRadioTransaction = modalContainer.querySelector("#modalRadioTransaction");
        modalRadioInfo.removeAttribute('active');
        modalRadioParrainage.removeAttribute('active');
        modalRadioTransaction.setAttribute('active','');
        

        if (!(modalRadioTransaction.getAttribute('loaded'))) {
            let modalTableTransaction = modalContainer.querySelector("#modalTableTransaction")
            modalTableTransaction.innerHTML = '';
            let result = await fetch(`${document.getElementById('apiGetTransaction').value}/${modalContainer.getAttribute('Userid')}`)
                .then((res) => res.json());

            console.log(result);

            for (let data of result) {
                modalTableTransaction.innerHTML += `
                    <tr>
						<td class="border border-teal-950 p-2">${this.decodeDate(data.date)}</td>
						<td class="border border-teal-950 p-2">${data.libelle}</td>
                        <td class="border border-teal-950 p-2 ${(data.signe == -1) ? 'text-red-600':'text-green-600'}">${(data.signe==-1)? '- ':'+ '}${data.montant}</td>
					</tr>
                `;
            }



            modalRadioTransaction.setAttribute('loaded', '1');

        }
    }

    decodeDate(toconvert) {
        let date = new Date(`${toconvert}Z`.replace(' ', 'T'));
        return `${date.getDate().toString().padStart(2, "0")}/${(date.getMonth() + 1).toString().padStart(2, "0")}/${date.getFullYear().toString()} - ${date.getHours().toString().padStart(2, "0")}:${date.getMinutes().toString().padStart(2, "0")}`;
    }

    closeModal(){
        let modalContainer = document.getElementById("modalContainer");
        let modalRadioInfo = modalContainer.querySelector('#modalRadioInfo');
        let modalRadioParrainage = modalContainer.querySelector("#modalRadioParrainage");
        let modalRadioTransaction = modalContainer.querySelector("#modalRadioTransaction");
        modalRadioInfo.removeAttribute('loaded','active');
        modalRadioParrainage.removeAttribute('loaded','active');
        modalRadioTransaction.removeAttribute('loaded','active');
        modalRadioInfo.control.checked = true;

        modalContainer.classList.add('hidden');

    }
}