import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Group\JoinController::__invoke
* @see app/Http/Controllers/Group/JoinController.php:17
* @route '/group/join/{group}'
*/
const JoinController = (args: { group: string | { slug: string } } | [group: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: JoinController.url(args, options),
    method: 'post',
})

JoinController.definition = {
    methods: ["post"],
    url: '/group/join/{group}',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Group\JoinController::__invoke
* @see app/Http/Controllers/Group/JoinController.php:17
* @route '/group/join/{group}'
*/
JoinController.url = (args: { group: string | { slug: string } } | [group: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions) => {
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

    return JoinController.definition.url
            .replace('{group}', parsedArgs.group.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Group\JoinController::__invoke
* @see app/Http/Controllers/Group/JoinController.php:17
* @route '/group/join/{group}'
*/
JoinController.post = (args: { group: string | { slug: string } } | [group: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: JoinController.url(args, options),
    method: 'post',
})

export default JoinController