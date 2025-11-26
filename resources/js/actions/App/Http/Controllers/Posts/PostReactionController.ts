import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Posts\PostReactionController::__invoke
* @see app/Http/Controllers/Posts/PostReactionController.php:15
* @route '/post/{post}/reaction'
*/
const PostReactionController = (args: { post: number | { id: number } } | [post: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: PostReactionController.url(args, options),
    method: 'post',
})

PostReactionController.definition = {
    methods: ["post"],
    url: '/post/{post}/reaction',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Posts\PostReactionController::__invoke
* @see app/Http/Controllers/Posts/PostReactionController.php:15
* @route '/post/{post}/reaction'
*/
PostReactionController.url = (args: { post: number | { id: number } } | [post: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
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

    return PostReactionController.definition.url
            .replace('{post}', parsedArgs.post.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Posts\PostReactionController::__invoke
* @see app/Http/Controllers/Posts/PostReactionController.php:15
* @route '/post/{post}/reaction'
*/
PostReactionController.post = (args: { post: number | { id: number } } | [post: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: PostReactionController.url(args, options),
    method: 'post',
})

export default PostReactionController