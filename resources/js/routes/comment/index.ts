import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../wayfinder'
/**
* @see \App\Http\Controllers\Comments\CommentController::store
* @see app/Http/Controllers/Comments/CommentController.php:26
* @route '/post/{post}/comment'
*/
export const store = (args: { post: number | { id: number } } | [post: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(args, options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/post/{post}/comment',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Comments\CommentController::store
* @see app/Http/Controllers/Comments/CommentController.php:26
* @route '/post/{post}/comment'
*/
store.url = (args: { post: number | { id: number } } | [post: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
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

    return store.definition.url
            .replace('{post}', parsedArgs.post.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Comments\CommentController::store
* @see app/Http/Controllers/Comments/CommentController.php:26
* @route '/post/{post}/comment'
*/
store.post = (args: { post: number | { id: number } } | [post: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Comments\CommentController::update
* @see app/Http/Controllers/Comments/CommentController.php:43
* @route '/post/comment/{comment}'
*/
export const update = (args: { comment: number | { id: number } } | [comment: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put"],
    url: '/post/comment/{comment}',
} satisfies RouteDefinition<["put"]>

/**
* @see \App\Http\Controllers\Comments\CommentController::update
* @see app/Http/Controllers/Comments/CommentController.php:43
* @route '/post/comment/{comment}'
*/
update.url = (args: { comment: number | { id: number } } | [comment: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
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

    return update.definition.url
            .replace('{comment}', parsedArgs.comment.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Comments\CommentController::update
* @see app/Http/Controllers/Comments/CommentController.php:43
* @route '/post/comment/{comment}'
*/
update.put = (args: { comment: number | { id: number } } | [comment: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

/**
* @see \App\Http\Controllers\Comments\CommentController::destroy
* @see app/Http/Controllers/Comments/CommentController.php:61
* @route '/post/comment/{comment}'
*/
export const destroy = (args: { comment: number | { id: number } } | [comment: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/post/comment/{comment}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Comments\CommentController::destroy
* @see app/Http/Controllers/Comments/CommentController.php:61
* @route '/post/comment/{comment}'
*/
destroy.url = (args: { comment: number | { id: number } } | [comment: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
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

    return destroy.definition.url
            .replace('{comment}', parsedArgs.comment.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Comments\CommentController::destroy
* @see app/Http/Controllers/Comments/CommentController.php:61
* @route '/post/comment/{comment}'
*/
destroy.delete = (args: { comment: number | { id: number } } | [comment: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\Comments\CommentReactionController::__invoke
* @see app/Http/Controllers/Comments/CommentReactionController.php:15
* @route '/post/comment/{comment}/reaction'
*/
export const reaction = (args: { comment: number | { id: number } } | [comment: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: reaction.url(args, options),
    method: 'post',
})

reaction.definition = {
    methods: ["post"],
    url: '/post/comment/{comment}/reaction',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Comments\CommentReactionController::__invoke
* @see app/Http/Controllers/Comments/CommentReactionController.php:15
* @route '/post/comment/{comment}/reaction'
*/
reaction.url = (args: { comment: number | { id: number } } | [comment: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions) => {
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

    return reaction.definition.url
            .replace('{comment}', parsedArgs.comment.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Comments\CommentReactionController::__invoke
* @see app/Http/Controllers/Comments/CommentReactionController.php:15
* @route '/post/comment/{comment}/reaction'
*/
reaction.post = (args: { comment: number | { id: number } } | [comment: number | { id: number } ] | number | { id: number }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: reaction.url(args, options),
    method: 'post',
})

const comment = {
    store,
    update,
    destroy,
    reaction,
}

export default comment