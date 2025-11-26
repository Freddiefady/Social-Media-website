import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Posts\PostAttachmentController::__invoke
* @see app/Http/Controllers/Posts/PostAttachmentController.php:17
* @route '/post/download/{attachment}'
*/
const PostAttachmentController = (args: { attachment: number | { id: number } } | [attachment: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: PostAttachmentController.url(args, options),
    method: 'get',
})

PostAttachmentController.definition = {
    methods: ["get","head"],
    url: '/post/download/{attachment}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Posts\PostAttachmentController::__invoke
* @see app/Http/Controllers/Posts/PostAttachmentController.php:17
* @route '/post/download/{attachment}'
*/
PostAttachmentController.url = (args: { attachment: number | { id: number } } | [attachment: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { attachment: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'id' in args) {
        args = { attachment: args.id }
    }

    if (Array.isArray(args)) {
        args = {
            attachment: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        attachment: typeof args.attachment === 'object'
        ? args.attachment.id
        : args.attachment,
    }

    return PostAttachmentController.definition.url
            .replace('{attachment}', parsedArgs.attachment.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Posts\PostAttachmentController::__invoke
* @see app/Http/Controllers/Posts/PostAttachmentController.php:17
* @route '/post/download/{attachment}'
*/
PostAttachmentController.get = (args: { attachment: number | { id: number } } | [attachment: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: PostAttachmentController.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Posts\PostAttachmentController::__invoke
* @see app/Http/Controllers/Posts/PostAttachmentController.php:17
* @route '/post/download/{attachment}'
*/
PostAttachmentController.head = (args: { attachment: number | { id: number } } | [attachment: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: PostAttachmentController.url(args, options),
    method: 'head',
})

export default PostAttachmentController