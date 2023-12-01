export default class Utils{
    
    mask(val:string, mask:string) {
        let maskared = '';
        let k = 0;
        for (let i = 0; i <= mask.length - 1; i++) {
            if (mask[i] === '#') {
                if (val[k])
                    maskared += val[k++];
            } else {
                if (mask[i])
                    maskared += mask[i];
            }
        }
        return maskared;
    }

    getMaskedDoc(doc:string){
        if(!doc) return doc;
        doc = doc.replace('/[^0-9]/g', '');
        return this.mask(doc, doc.length > 11 ? '##.###.###/####-##' : '###.###.###-##');
    }

    dateFormat(data:any) {
        if(!data) return data
        const date = new Date(data);
        
        const year = date.toLocaleString("default", { year: "numeric" });
        const month = date.toLocaleString("default", { month: "2-digit" });
        const day = date.toLocaleString("default", { day: "2-digit" });
        
        return `${date.getUTCDate().toString().padStart(2, '0')}/${(date.getUTCMonth()+1).toString().padStart(2, '0')}/${date.getUTCFullYear()}`;
    }

    dateTimeFormat(dataString:any) {
        if(!dataString) return dataString;
        const data = new Date(dataString);
      
        const dia = String(data.getDate()).padStart(2, '0');
        const mes = String(data.getMonth() + 1).padStart(2, '0'); // Meses são indexados de 0 a 11
        const ano = data.getFullYear();
      
        const horas = String(data.getHours()).padStart(2, '0');
        const minutos = String(data.getMinutes()).padStart(2, '0');
      
        return `${dia}/${mes}/${ano} ${horas}:${minutos}`;
      }
      

    getMonthName(mes:number, lang:string) {
        const en = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        const pt = ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];
      
        if (lang === "EN") {
          return en[mes - 1];
        }
      
        return pt[mes - 1];
    }

    getWeekName(dia:number, lang:string) {
        const en = ["Sunday", "Monday", "Thursday", "Wednesday", "Tuesday", "Friday", "Saturday"];
        const pt = ["Domingo", "Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sábado"];
      
        if (lang === "EN") {
          return en[dia];
        }
      
        return pt[dia];
    }

}