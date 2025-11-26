import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Group\DestroyUserController::__invoke
* @see app/Http/Controllers/Group/DestroyUserController.php:19
* @route '/group/destroy-user/{group}'
*/
const DestroyUserController = (args: { group: string | { slug: string } } | [group: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: DestroyUserController.url(args, options),
    method: 'delete',
})

DestroyUserController.definition = {
    methods: ["delete"],
    url: '/group/destroy-user/{group}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Group\DestroyUserController::__invoke
* @see app/Http/Controllers/Group/DestroyUserController.php:19
* @route '/group/destroy-user/{group}'
*/
DestroyUserController.url = (args: { group: string | { slug: string } } | [group: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions) => {
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

    return DestroyUserController.definition.url
            .replace('{group}', parsedArgs.group.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Group\DestroyUserController::__invoke
* @see app/Http/Controllers/Group/DestroyUserController.php:19
* @route '/group/destroy-user/{group}'
*/
DestroyUserController.delete = (args: { group: string | { slug: string } } | [group: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: DestroyUserController.url(args, options),
    method: 'delete',
})

export default DestroyUserController