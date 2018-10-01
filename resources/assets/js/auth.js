class Auth {
    constructor() {
        this.token = window.localStorage.getItem('token');

        let userData = window.localStorage.getItem('user');
        this.user = userData ? JSON.parse(userData) : null;
        this.roleId = this.user ? this.user.role_id : null;

        if (this.token) {
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + this.token;
            this.getUser();
        }
    }

    login(token, user) {
        window.localStorage.setItem('token', token);
        window.localStorage.setItem('user', JSON.stringify(user));

        axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;

        this.token = token;
        this.user = user;
        this.roleId = user.role_id;

        Event.$emit('userLoggedIn');
        this.redirectTo();
    }

    redirectTo() {
        if (this.roleId === 1) {
            window.location.href = "./admin"
        } else if (this.roleId === 2) {
            window.location.href = "./client"
        }
    }

    getUser() {
        var self = this;
        axios.get('./api/get-user')
        .then(({user}) => {
            this.user = user;
        }).catch(error => {
            self.logout();
        });
    }

    check() {
        return !!this.token;
    }

    logout() {
        window.localStorage.removeItem('token');
        window.localStorage.removeItem('user');

        axios.defaults.headers.common['Authorization'] = '';

        this.token = '';
        this.user = '';

        // Event.$emit('userLoggedIn');
    }
}

export default Auth;