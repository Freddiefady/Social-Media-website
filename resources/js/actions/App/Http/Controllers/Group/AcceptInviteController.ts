import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Group\AcceptInviteController::__invoke
* @see app/Http/Controllers/Group/AcceptInviteController.php:20
* @route '/group/approve-invitation/{token}'
*/
const AcceptInviteController = (args: { token: string | number } | [token: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: AcceptInviteController.url(args, options),
    method: 'get',
})

AcceptInviteController.definition = {
    methods: ["get","head"],
    url: '/group/approve-invitation/{token}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Group\AcceptInviteController::__invoke
* @see app/Http/Controllers/Group/AcceptInviteController.php:20
* @route '/group/approve-invitation/{token}'
*/
AcceptInviteController.url = (args: { token: string | number } | [token: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { token: args }
    }

    if (Array.isArray(args)) {
        args = {
            token: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        token: args.token,
    }

    return AcceptInviteController.definition.url
            .replace('{token}', parsedArgs.token.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Group\AcceptInviteController::__invoke
* @see app/Http/Controllers/Group/AcceptInviteController.php:20
* @route '/group/approve-invitation/{token}'
*/
AcceptInviteController.get = (args: { token: string | number } | [token: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: AcceptInviteController.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Group\AcceptInviteController::__invoke
* @see app/Http/Controllers/Group/AcceptInviteController.php:20
* @route '/group/approve-invitation/{token}'
*/
AcceptInviteController.head = (args: { token: string | number } | [token: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: AcceptInviteController.url(args, options),
    method: 'head',
})

export default AcceptInviteController