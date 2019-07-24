const AreaRestrita = {
    sessionName: 'painel',
    get() {
        return localStorage[this.sessionName] || false
    },
    save(valor) {
        localStorage.setItem(this.sessionName, valor)
        return this
    },
    login() {
        let dados = Form('#entrar').get().valor().campos
        dados.login = 1;
        Banco(`${Route.uri()}/app/auth`)
            .data(dados)
            .post(x => {
                if (!x.error) {
                    this.save(x.token)
                    Route.redireciona(`${Route.uri()}/admin/dash.html`)
                } else {
                    alert('Usuário ou senha errado');
                }
            })
    },
    logout() {
        localStorage.removeItem(this.sessionName)
    },
}