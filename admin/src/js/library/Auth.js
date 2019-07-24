const Auth = {
    nomeSessao: 'sessao_site',
    sessaoTipo: 'localStorage',
    sessao: '',
    urlAutenticacao: 'http://',
    estaLogado: false,
    endPoints: {
        "token": "http://upsite.con/app/auth2?token={{tokenId}}",
        "logout": "http://upsite.con/app/auth2?logout={{tokenId}}",
        "login": "http://upsite.con/app/auth2?login=1&email={{userEmail}}&pass={{userPass}}",
    },
    opcoes: {
        headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
        credentials: "same-origin",
        method: 'POST',
        mode: 'cors',
        cache: 'default',
        body: null
    },
    objToUrl( obj ) {
        let indices =  Object.keys( obj )
        let url     = indices.map( i => `${i}=${obj[i]}` ).join('&')
        return encodeURI( url )
    },
    postHttp( url, obj, hof ) {
        this.opcoes.body   = this.objToUrl( obj );
        fetch( `${this.urlAutenticacao}/${url}`, this.opcoes )
        .then( j => j.json() )
        .then( x => {
            hof( x );
        } );
        return true;
    },
    getHttp( url, obj, hof ) {
        let paramentros = this.objToUrl( obj );
        fetch( `${this.urlAutenticacao}${url}?${paramentros}`,  )
        .then( j => j.json() )
        .then( x => {
            hof( x )
        } )
    },
    init() {
        if( this.get() != null ) {
            this.sessaoValida()
        }        
    },
    sessaoValida() {
        this.getHttp( 'auth2', { token: this.get() }, respostaHttp => {
            if( !respostaHttp.token ) {
                Auth.apagar()
            }
        } )
        return true
    },
    areaPublica() {
        return this.logado == false
    },
    areaPrivada() {
        return this.logado == true
    },
    entrar( obj, hof ) {
        this.postHttp( 'auth2', obj, el =>{ 
            hof( el )
            if( el.error ) {
                Auth.apagar()
                return false
            }
            Auth.sessao     = el.token
            Auth.estaLogado = true
            Auth.salvar()
            return true
        } )
    },
    sair() {
        this.getHttp( 'auth', { logout: this.get() }, () => {} )
        this.apagar()
        return true
    },
    logado() {
        return this.estaLogado
    },
    salvar() {
        window[this.sessaoTipo].setItem( this.nomeSessao, this.sessao )
        return true
    },
    apagar() {
        window[this.sessaoTipo].removeItem( this.nomeSessao )
        this.estaLogado = false
        this.sessao     = ''
        return true
    },
    get() {
        return window[this.sessaoTipo].getItem( this.nomeSessao )
    },
}


