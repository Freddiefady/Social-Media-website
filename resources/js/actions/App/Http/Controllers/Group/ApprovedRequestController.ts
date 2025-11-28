import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Group\ApprovedRequestController::__invoke
* @see app/Http/Controllers/Group/ApprovedRequestController.php:18
* @route '/group/approve/{group}'
*/
const ApprovedRequestController = (args: { group: string | { slug: string } } | [group: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: ApprovedRequestController.url(args, options),
    method: 'post',
})

ApprovedRequestController.definition = {
    methods: ["post"],
    url: '/group/approve/{group}',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Group\ApprovedRequestController::__invoke
* @see app/Http/Controllers/Group/ApprovedRequestController.php:18
* @route '/group/approve/{group}'
*/
ApprovedRequestController.url = (args: { group: string | { slug: string } } | [group: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions) => {
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

    return ApprovedRequestController.definition.url
            .replace('{group}', parsedArgs.group.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Group\ApprovedRequestController::__invoke
* @see app/Http/Controllers/Group/ApprovedRequestController.php:18
* @route '/group/approve/{group}'
*/
ApprovedRequestController.post = (args: { group: string | { slug: string } } | [group: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: ApprovedRequestController.url(args, options),
    method: 'post',
})

export default ApprovedRequestController