import {wrap} from 'svelte-spa-router/wrap'

export default {
    // Exact path
    '/': wrap({
        asyncComponent: () => import('./routes/Home.svelte')
    }),

    // Using named parameters, with last being optional
    '/ervaring':  wrap({
        asyncComponent: () => import('./routes/Experience.svelte')
    }),

    // Wildcard parameter
    // '/projecten':  wrap({
    //     asyncComponent: () => import('./routes/Projects.svelte')
    // }),

    // Wildcard parameter
    '/contact':  wrap({
        asyncComponent: () => import('./routes/Contact.svelte')
    }),

    // Catch-all
    // This is optional, but if present it must be the last
    '*':  wrap({
        asyncComponent: () => import('./routes/NotFound.svelte')
    }),
}