import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Group\InviteController::__invoke
* @see app/Http/Controllers/Group/InviteController.php:19
* @route '/group/invite/{group}'
*/
const InviteController = (args: { group: string | { slug: string } } | [group: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: InviteController.url(args, options),
    method: 'post',
})

InviteController.definition = {
    methods: ["post"],
    url: '/group/invite/{group}',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Group\InviteController::__invoke
* @see app/Http/Controllers/Group/InviteController.php:19
* @route '/group/invite/{group}'
*/
InviteController.url = (args: { group: string | { slug: string } } | [group: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions) => {
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

    return InviteController.definition.url
            .replace('{group}', parsedArgs.group.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Group\InviteController::__invoke
* @see app/Http/Controllers/Group/InviteController.php:19
* @route '/group/invite/{group}'
*/
InviteController.post = (args: { group: string | { slug: string } } | [group: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: InviteController.url(args, options),
    method: 'post',
})

export default InviteController