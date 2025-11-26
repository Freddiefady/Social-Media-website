import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../wayfinder'
import generate from './generate'
/**
* @see \App\Http\Controllers\Posts\PostController::store
* @see app/Http/Controllers/Posts/PostController.php:44
* @route '/post'
*/
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/post',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Posts\PostController::store
* @see app/Http/Controllers/Posts/PostController.php:44
* @route '/post'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Posts\PostController::store
* @see app/Http/Controllers/Posts/PostController.php:44
* @route '/post'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Posts\PostController::show
* @see app/Http/Controllers/Posts/PostController.php:27
* @route '/post/{post}'
*/
export const show = (args: { post: number | { id: number } } | [post: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/post/{post}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Posts\PostController::show
* @see app/Http/Controllers/Posts/PostController.php:27
* @route '/post/{post}'
*/
show.url = (args: { post: number | { id: number } } | [post: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
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

    return show.definition.url
            .replace('{post}', parsedArgs.post.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Posts\PostController::show
* @see app/Http/Controllers/Posts/PostController.php:27
* @route '/post/{post}'
*/
show.get = (args: { post: number | { id: number } } | [post: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Posts\PostController::show
* @see app/Http/Controllers/Posts/PostController.php:27
* @route '/post/{post}'
*/
show.head = (args: { post: number | { id: number } } | [post: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Posts\PostController::update
* @see app/Http/Controllers/Posts/PostController.php:61
* @route '/post/{post}'
*/
export const update = (args: { post: number | { id: number } } | [post: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put","patch"],
    url: '/post/{post}',
} satisfies RouteDefinition<["put","patch"]>

/**
* @see \App\Http\Controllers\Posts\PostController::update
* @see app/Http/Controllers/Posts/PostController.php:61
* @route '/post/{post}'
*/
update.url = (args: { post: number | { id: number } } | [post: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
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

    return update.definition.url
            .replace('{post}', parsedArgs.post.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Posts\PostController::update
* @see app/Http/Controllers/Posts/PostController.php:61
* @route '/post/{post}'
*/
update.put = (args: { post: number | { id: number } } | [post: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

/**
* @see \App\Http\Controllers\Posts\PostController::update
* @see app/Http/Controllers/Posts/PostController.php:61
* @route '/post/{post}'
*/
update.patch = (args: { post: number | { id: number } } | [post: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\Posts\PostController::destroy
* @see app/Http/Controllers/Posts/PostController.php:77
* @route '/post/{post}'
*/
export const destroy = (args: { post: number | { id: number } } | [post: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/post/{post}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Posts\PostController::destroy
* @see app/Http/Controllers/Posts/PostController.php:77
* @route '/post/{post}'
*/
destroy.url = (args: { post: number | { id: number } } | [post: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
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

    return destroy.definition.url
            .replace('{post}', parsedArgs.post.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Posts\PostController::destroy
* @see app/Http/Controllers/Posts/PostController.php:77
* @route '/post/{post}'
*/
destroy.delete = (args: { post: number | { id: number } } | [post: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\Posts\PostAttachmentController::__invoke
* @see app/Http/Controllers/Posts/PostAttachmentController.php:17
* @route '/post/download/{attachment}'
*/
export const download = (args: { attachment: number | { id: number } } | [attachment: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: download.url(args, options),
    method: 'get',
})

download.definition = {
    methods: ["get","head"],
    url: '/post/download/{attachment}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Posts\PostAttachmentController::__invoke
* @see app/Http/Controllers/Posts/PostAttachmentController.php:17
* @route '/post/download/{attachment}'
*/
download.url = (args: { attachment: number | { id: number } } | [attachment: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
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

    return download.definition.url
            .replace('{attachment}', parsedArgs.attachment.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Posts\PostAttachmentController::__invoke
* @see app/Http/Controllers/Posts/PostAttachmentController.php:17
* @route '/post/download/{attachment}'
*/
download.get = (args: { attachment: number | { id: number } } | [attachment: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: download.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Posts\PostAttachmentController::__invoke
* @see app/Http/Controllers/Posts/PostAttachmentController.php:17
* @route '/post/download/{attachment}'
*/
download.head = (args: { attachment: number | { id: number } } | [attachment: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: download.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Posts\PostReactionController::__invoke
* @see app/Http/Controllers/Posts/PostReactionController.php:15
* @route '/post/{post}/reaction'
*/
export const reaction = (args: { post: number | { id: number } } | [post: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: reaction.url(args, options),
    method: 'post',
})

reaction.definition = {
    methods: ["post"],
    url: '/post/{post}/reaction',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Posts\PostReactionController::__invoke
* @see app/Http/Controllers/Posts/PostReactionController.php:15
* @route '/post/{post}/reaction'
*/
reaction.url = (args: { post: number | { id: number } } | [post: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
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

    return reaction.definition.url
            .replace('{post}', parsedArgs.post.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Posts\PostReactionController::__invoke
* @see app/Http/Controllers/Posts/PostReactionController.php:15
* @route '/post/{post}/reaction'
*/
reaction.post = (args: { post: number | { id: number } } | [post: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: reaction.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Posts\UrlPreviewController::__invoke
* @see app/Http/Controllers/Posts/UrlPreviewController.php:19
* @route '/post/url-preview'
*/
export const urlPreview = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: urlPreview.url(options),
    method: 'post',
})

urlPreview.definition = {
    methods: ["post"],
    url: '/post/url-preview',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Posts\UrlPreviewController::__invoke
* @see app/Http/Controllers/Posts/UrlPreviewController.php:19
* @route '/post/url-preview'
*/
urlPreview.url = (options?: RouteQueryOptions) => {
    return urlPreview.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Posts\UrlPreviewController::__invoke
* @see app/Http/Controllers/Posts/UrlPreviewController.php:19
* @route '/post/url-preview'
*/
urlPreview.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: urlPreview.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Posts\PinPostController::__invoke
* @see app/Http/Controllers/Posts/PinPostController.php:20
* @route '/post/{post}/pin'
*/
export const pin = (args: { post: number | { id: number } } | [post: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: pin.url(args, options),
    method: 'post',
})

pin.definition = {
    methods: ["post"],
    url: '/post/{post}/pin',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Posts\PinPostController::__invoke
* @see app/Http/Controllers/Posts/PinPostController.php:20
* @route '/post/{post}/pin'
*/
pin.url = (args: { post: number | { id: number } } | [post: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
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

    return pin.definition.url
            .replace('{post}', parsedArgs.post.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Posts\PinPostController::__invoke
* @see app/Http/Controllers/Posts/PinPostController.php:20
* @route '/post/{post}/pin'
*/
pin.post = (args: { post: number | { id: number } } | [post: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: pin.url(args, options),
    method: 'post',
})

const post = {
    store,
    show,
    update,
    destroy,
    download,
    reaction,
    generate,
    urlPreview,
    pin,
}

export default post