let url = window.laravel.vueBaseUrl
let admin_url = url + '/admin/'
// let url = '/'
// let admin_url = '/admin/'
const routes = [
    {
        path: url + '404',
        name: '404',
        component: require('./components/Error/404'),
        abstract: true,
        meta: {
            layout: 'error'
        }
    },
    {
        path: url,
        name: 'home',
        component: require('./components/FrontEnd/Index'),
        abstract: true,
        meta: {
            layout: 'front'
        }
    },
    {
        path: "*",
        component: require('./components/Error/404'),
        meta: {
            layout: 'error'
        }
    },
    { 
        path: url + 'login', 
        component: require('./components/Authentication/Login'),
        name: 'login',
        meta: {
            layout: 'login',
            middlewareAuth: false
        },
        beforeEnter(to, from, next) {
            if (auth.check()) {
                if (auth.roleId === 1) {
                    next({name: 'admin'});                    
                }
            } else {
                next();
            }
        },
    },
    { 
    	path: admin_url, 
    	component: require('./components/Admin/Index'),
        name: 'admin',
        meta: {
            layout: 'admin',
            breadcrumb: [
                {
                    name: 'Home',
                    path: admin_url
                }
            ],
            middlewareAuth: true,
            roleId: 1
        }
    },
    { 
        path: admin_url + 'url-shortner', 
        component: require('./components/Admin/UrlShortner/Index'),
        meta: {
            layout: 'admin',
            breadcrumb: [
                {
                    name: 'Home',
                    path: admin_url, 
                },
                {
                    name: 'Url Shortner',
                    path: admin_url + 'url-shortner', 
                }
            ],
            middlewareAuth: true,
            roleId: 1
        },
    },
];

export default routes;