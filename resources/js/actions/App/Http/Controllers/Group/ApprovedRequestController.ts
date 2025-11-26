import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Group\ApprovedRequestController::__invoke
* @see app/Http/Controllers/Group/ApprovedRequestController.php:18
* @route '/group/approve-invitation/{token}'
*/
const ApprovedRequestController983fd4e54402357eb0922103366563b9 = (args: { token: string | number } | [token: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ApprovedRequestController983fd4e54402357eb0922103366563b9.url(args, options),
    method: 'get',
})

ApprovedRequestController983fd4e54402357eb0922103366563b9.definition = {
    methods: ["get","head"],
    url: '/group/approve-invitation/{token}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Group\ApprovedRequestController::__invoke
* @see app/Http/Controllers/Group/ApprovedRequestController.php:18
* @route '/group/approve-invitation/{token}'
*/
ApprovedRequestController983fd4e54402357eb0922103366563b9.url = (args: { token: string | number } | [token: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return ApprovedRequestController983fd4e54402357eb0922103366563b9.definition.url
            .replace('{token}', parsedArgs.token.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Group\ApprovedRequestController::__invoke
* @see app/Http/Controllers/Group/ApprovedRequestController.php:18
* @route '/group/approve-invitation/{token}'
*/
ApprovedRequestController983fd4e54402357eb0922103366563b9.get = (args: { token: string | number } | [token: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ApprovedRequestController983fd4e54402357eb0922103366563b9.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Group\ApprovedRequestController::__invoke
* @see app/Http/Controllers/Group/ApprovedRequestController.php:18
* @route '/group/approve-invitation/{token}'
*/
ApprovedRequestController983fd4e54402357eb0922103366563b9.head = (args: { token: string | number } | [token: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ApprovedRequestController983fd4e54402357eb0922103366563b9.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Group\ApprovedRequestController::__invoke
* @see app/Http/Controllers/Group/ApprovedRequestController.php:18
* @route '/group/approve/{group}'
*/
const ApprovedRequestController0eafe4169c0919f3d965158e8d005610 = (args: { group: string | { slug: string } } | [group: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: ApprovedRequestController0eafe4169c0919f3d965158e8d005610.url(args, options),
    method: 'post',
})

ApprovedRequestController0eafe4169c0919f3d965158e8d005610.definition = {
    methods: ["post"],
    url: '/group/approve/{group}',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Group\ApprovedRequestController::__invoke
* @see app/Http/Controllers/Group/ApprovedRequestController.php:18
* @route '/group/approve/{group}'
*/
ApprovedRequestController0eafe4169c0919f3d965158e8d005610.url = (args: { group: string | { slug: string } } | [group: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { group: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'slug' in args) {
        args = { group: args.slug }
    }

    if (Array.isArray(args)) {
        args = {
            group: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        group: typeof args.group === 'object'
        ? args.group.slug
        : args.group,
    }

    return ApprovedRequestController0eafe4169c0919f3d965158e8d005610.definition.url
            .replace('{group}', parsedArgs.group.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Group\ApprovedRequestController::__invoke
* @see app/Http/Controllers/Group/ApprovedRequestController.php:18
* @route '/group/approve/{group}'
*/
ApprovedRequestController0eafe4169c0919f3d965158e8d005610.post = (args: { group: string | { slug: string } } | [group: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: ApprovedRequestController0eafe4169c0919f3d965158e8d005610.url(args, options),
    method: 'post',
})

const ApprovedRequestController = {
    '/group/approve-invitation/{token}': ApprovedRequestController983fd4e54402357eb0922103366563b9,
    '/group/approve/{group}': ApprovedRequestController0eafe4169c0919f3d965158e8d005610,
}

export default ApprovedRequestController