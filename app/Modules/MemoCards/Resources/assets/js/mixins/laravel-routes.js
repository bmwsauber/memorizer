const routes = window.Laravel.routes;
export default {
    methods: {
        // works only for routes like users/{id}/conversations and accepts only one argument
        route: function () {
            let args = Array.prototype.slice.call(arguments);
            let name = args.shift();
            if (routes[name] === undefined) {
                console.error('Route not found ', name);
            } else {
                return window.Laravel.baseUrl + '/' + routes[name]
                    .split('/')
                    .map(s => s[0] === '{' ? args.shift() : s)
                    .join('/');
            }
        }
        // todo: white new method and/or regExp to routes like /users/{id}/conversations/{id}
    },
};
