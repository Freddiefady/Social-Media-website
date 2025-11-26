import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Comments\CommentReactionController::__invoke
* @see app/Http/Controllers/Comments/CommentReactionController.php:15
* @route '/post/comment/{comment}/reaction'
*/
const CommentReactionController = (args: { comment: number | { id: number } } | [comment: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: CommentReactionController.url(args, options),
    method: 'post',
})

CommentReactionController.definition = {
    methods: ["post"],
    url: '/post/comment/{comment}/reaction',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Comments\CommentReactionController::__invoke
* @see app/Http/Controllers/Comments/CommentReactionController.php:15
* @route '/post/comment/{comment}/reaction'
*/
CommentReactionController.url = (args: { comment: number | { id: number } } | [comment: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { comment: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { comment: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            comment: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        comment: typeof args.comment === 'object'
        ? args.comment.id
        : args.comment,
    }

    return CommentReactionController.definition.url
            .replace('{comment}', parsedArgs.comment.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Comments\CommentReactionController::__invoke
* @see app/Http/Controllers/Comments/CommentReactionController.php:15
* @route '/post/comment/{comment}/reaction'
*/
CommentReactionController.post = (args: { comment: number | { id: number } } | [comment: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: CommentReactionController.url(args, options),
    method: 'post',
})

export default CommentReactionController