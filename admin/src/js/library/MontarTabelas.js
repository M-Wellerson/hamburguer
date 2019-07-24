
const completo = [
    {"name": "Luke Skywalker", "height": "172", "mass": "77", "hair_color": "blond", "skin_color": "fair",  "eye_color": "blue",  "birth_year": "19BBY",  "gender": "male", },
    {"name": "C-3PO", "height": "167", "mass": "75", "hair_color": "n/a", "skin_color": "gold", "eye_color": "yellow", "birth_year": "112BBY", "gender": "n/a", },
    {"name": "R2-D2", "height": "96", "mass": "32", "hair_color": "n/a", "skin_color": "white, blue", "eye_color": "red", "birth_year": "33BBY", "gender": "n/a", },
    {"name": "Darth Vader", "height": "202", "mass": "136", "hair_color": "none", "skin_color": "white", "eye_color": "yellow", "birth_year": "41.9BBY", "gender": "male", },
    {"name": "Leia Organa", "height": "150", "mass": "49", "hair_color": "brown", "skin_color": "light", "eye_color": "brown", "birth_year": "19BBY", "gender": "female", },
    { "name": "Owen Lars", "height": "178", "mass": "120", "hair_color": "brown, grey", "skin_color": "light", "eye_color": "blue", "birth_year": "52BBY", "gender": "male", }
]

const Table = {
    dados: [],
    filtros: [],
    idElementHTML: '',
    
    getDados() {
        return this.dados;
    },

    setDados(params) {
        this.dados = params;
    },

    getFiltros(){
        return this.filtros;
    },

    setFiltros(params) {
        this.filtros = params;
    },

    filtrarCabecalho() {
        if(this.filtros.length == 0) {
           let dados = this.dados
           dados = Object.keys(dados[0]).map(e => e.toUpperCase().replace('_', ' '))
           return dados
        }else {
            let filtros = {};
            this.getFiltros().forEach(e => {
                filtros[e.text] = e.text
            });
            return filtros;
        }
    },

    substituirDadosEmStrings(str, obj) {
        const key = Object.keys(obj)
        const value = Object.values(obj)
        for(let i = 0; i <= key.length ; i++) {
            str = str.replace(`{${key[i]}}`, value[i])
        }
        return str
    },

    filtrarBody() {
        if(this.filtros.length !== 0) {
            let data = this.getDados();
            let nos = this.getFiltros();
           
            let apenas_nos = nos.map(no => no.no);
            
            data = data.map(dts => {
                let obj = {};
                apenas_nos.forEach(n => {
                    obj[n] = dts[n]
                })
                return obj
            })
            
            this.dados = [...data]

            nos.forEach(e => {
                if(e.str !== undefined && e.sub !== undefined) {
                    let sub = this.substituirDadosEmStrings(e.str, e.sub)
                    let dd = data.forEach(d => d[e.no] = sub
                    )                   
                }
            })
            
        }
    },

    drawHeaderHTML() {
        let th = [this.filtrarCabecalho()];
        return th.map(t => {
            let valor = Object.values(t).map(v => `<th>${v.toUpperCase()}</th>`).join('')
            return valor
        })
        
    },

    drawBodyHTML() {
        let td = this.dados
        return td.map(bd => {
            let valor = Object.values(bd).map(v => `<td>${v}</td>`).join('')
            return `<tr>${valor}</tr>`
        }).join('')
    },

    // aceita uma classe
    drawTableHTML(estilo) {
        document.getElementById(this.idElementHTML).innerHTML = `
        <table class='${estilo}'>
            <thead>
                <tr>
                    ${this.drawHeaderHTML()}
                </tr>
            </thead>
            <tbody>
                ${this.drawBodyHTML()}
            </tbody>
        </table>
    `
    }

}

Table.idElementHTML = "root"

Table.setDados(completo)
Table.setFiltros([
    {
        text: 'Name',
        no: 'name'
    },
    {
        text: 'Altura',
        no: 'height'
    },
    {   
        text:'Olhos', 
        no:'eye_color',  
        str: '<p style="{est}">i</p>', 
        sub: {est: 'background: #000; width: 20px; border-radius: 50px;'}
    }
])

Table.filtrarCabecalho()
Table.filtrarBody()

Table.drawTableHTML('tt')

console.table(Table.dados)
