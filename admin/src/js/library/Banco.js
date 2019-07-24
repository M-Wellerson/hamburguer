const Banco = function( uri ) {
    return {
        uri,
        _data: {},
        _encodeUri: "",
        _resultHttp: "",
        options: {
            headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
            credentials: "same-origin",
            method: 'POST',
            mode: 'cors',
            cache: 'default',
            body: null
        },
        objToUrl( obj ) {
            let indices =  Object.keys( obj );
            let url     = indices.map( i => `${i}=${obj[i]}` ).join('&');
            return encodeURI( url );            
        },
        data( obj ) {
            this._data      = obj
            this._encodeUri = this.objToUrl( obj )
            return this
        },
        async post( func ) {
            this.antesAtualizar()
            this.options.body = this._encodeUri
            let chamaHttp     = await fetch( `${this.uri}`, this.options )
            let json          = await chamaHttp.json()
            this._resultHttp  =  json
            func( json )
            this.depoisAtualizar()
            return this
        },        
        async get( func ) {
            this.antesAtualizar()           
            let chamaHttp    = await fetch( `${this.uri}?${this._encodeUri}` )
            let json         = await chamaHttp.json()
            this._resultHttp =  json
            func( json )
            this.depoisAtualizar()
            return this
        },
        antesAtualizar( fnc = ()=>{} ) {
            fnc( this )
            return this
        },
        depoisAtualizar( fnc = ()=>{} ) {
            fnc( this )
            return this
        },
    }
}

/*
    Banco( 'http://upsite.con/app' )
    .data( {} )
    .get( x => {
        log( x )
    } )
*/
