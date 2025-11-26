import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Group\ChangeRoleController::__invoke
* @see app/Http/Controllers/Group/ChangeRoleController.php:19
* @route '/group/change-role/{group}'
*/
const ChangeRoleController = (args: { group: string | { slug: string } } | [group: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: ChangeRoleController.url(args, options),
    method: 'post',
})

ChangeRoleController.definition = {
    methods: ["post"],
    url: '/group/change-role/{group}',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Group\ChangeRoleController::__invoke
* @see app/Http/Controllers/Group/ChangeRoleController.php:19
* @route '/group/change-role/{group}'
*/
ChangeRoleController.url = (args: { group: string | { slug: string } } | [group: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions) => {
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

    return ChangeRoleController.definition.url
            .replace('{group}', parsedArgs.group.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Group\ChangeRoleController::__invoke
* @see app/Http/Controllers/Group/ChangeRoleController.php:19
* @route '/group/change-role/{group}'
*/
ChangeRoleController.post = (args: { group: string | { slug: string } } | [group: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: ChangeRoleController.url(args, options),
    method: 'post',
})

export default ChangeRoleController