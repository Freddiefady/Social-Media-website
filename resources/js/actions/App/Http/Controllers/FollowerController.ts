import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\FollowerController::__invoke
* @see app/Http/Controllers/FollowerController.php:16
* @route '/user/follower/{user}'
*/
const FollowerController = (args: { user: number | { id: number } } | [user: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: FollowerController.url(args, options),
    method: 'post',
})

FollowerController.definition = {
    methods: ["post"],
    url: '/user/follower/{user}',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\FollowerController::__invoke
* @see app/Http/Controllers/FollowerController.php:16
* @route '/user/follower/{user}'
*/
FollowerController.url = (args: { user: number | { id: number } } | [user: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { user: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { user: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            user: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        user: typeof args.user === 'object'
        ? args.user.id
        : args.user,
    }

    return FollowerController.definition.url
            .replace('{user}', parsedArgs.user.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\FollowerController::__invoke
* @see app/Http/Controllers/FollowerController.php:16
* @route '/user/follower/{user}'
*/
FollowerController.post = (args: { user: number | { id: number } } | [user: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: FollowerController.url(args, options),
    method: 'post',
})

export default FollowerController