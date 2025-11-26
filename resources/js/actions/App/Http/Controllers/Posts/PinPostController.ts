import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Posts\PinPostController::__invoke
* @see app/Http/Controllers/Posts/PinPostController.php:20
* @route '/post/{post}/pin'
*/
const PinPostController = (args: { post: number | { id: number } } | [post: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: PinPostController.url(args, options),
    method: 'post',
})

PinPostController.definition = {
    methods: ["post"],
    url: '/post/{post}/pin',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Posts\PinPostController::__invoke
* @see app/Http/Controllers/Posts/PinPostController.php:20
* @route '/post/{post}/pin'
*/
PinPostController.url = (args: { post: number | { id: number } } | [post: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { post: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { post: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            post: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        post: typeof args.post === 'object'
        ? args.post.id
        : args.post,
    }

    return PinPostController.definition.url
            .replace('{post}', parsedArgs.post.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Posts\PinPostController::__invoke
* @see app/Http/Controllers/Posts/PinPostController.php:20
* @route '/post/{post}/pin'
*/
PinPostController.post = (args: { post: number | { id: number } } | [post: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: PinPostController.url(args, options),
    method: 'post',
})

export default PinPostController