import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../wayfinder'
/**
* @see \App\Http\Controllers\Group\GroupController::store
* @see app/Http/Controllers/Group/GroupController.php:38
* @route '/group'
*/
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/group',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Group\GroupController::store
* @see app/Http/Controllers/Group/GroupController.php:38
* @route '/group'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Group\GroupController::store
* @see app/Http/Controllers/Group/GroupController.php:38
* @route '/group'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Group\GroupController::show
* @see app/Http/Controllers/Group/GroupController.php:50
* @route '/group/{group}'
*/
export const show = (args: { group: string | { slug: string } } | [group: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/group/{group}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Group\GroupController::show
* @see app/Http/Controllers/Group/GroupController.php:50
* @route '/group/{group}'
*/
show.url = (args: { group: string | { slug: string } } | [group: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions) => {
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

    return show.definition.url
            .replace('{group}', parsedArgs.group.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Group\GroupController::show
* @see app/Http/Controllers/Group/GroupController.php:50
* @route '/group/{group}'
*/
show.get = (args: { group: string | { slug: string } } | [group: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Group\GroupController::show
* @see app/Http/Controllers/Group/GroupController.php:50
* @route '/group/{group}'
*/
show.head = (args: { group: string | { slug: string } } | [group: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Group\GroupController::update
* @see app/Http/Controllers/Group/GroupController.php:73
* @route '/group/{group}'
*/
export const update = (args: { group: string | { slug: string } } | [group: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

update.definition = {
    methods: ["put","patch"],
    url: '/group/{group}',
} satisfies RouteDefinition<["put","patch"]>

/**
* @see \App\Http\Controllers\Group\GroupController::update
* @see app/Http/Controllers/Group/GroupController.php:73
* @route '/group/{group}'
*/
update.url = (args: { group: string | { slug: string } } | [group: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions) => {
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

    return update.definition.url
            .replace('{group}', parsedArgs.group.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Group\GroupController::update
* @see app/Http/Controllers/Group/GroupController.php:73
* @route '/group/{group}'
*/
update.put = (args: { group: string | { slug: string } } | [group: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: update.url(args, options),
    method: 'put',
})

/**
* @see \App\Http\Controllers\Group\GroupController::update
* @see app/Http/Controllers/Group/GroupController.php:73
* @route '/group/{group}'
*/
update.patch = (args: { group: string | { slug: string } } | [group: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(args, options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\Group\GroupController::destroy
* @see app/Http/Controllers/Group/GroupController.php:83
* @route '/group/{group}'
*/
export const destroy = (args: { group: string | { slug: string } } | [group: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/group/{group}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Group\GroupController::destroy
* @see app/Http/Controllers/Group/GroupController.php:83
* @route '/group/{group}'
*/
destroy.url = (args: { group: string | { slug: string } } | [group: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions) => {
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

    return destroy.definition.url
            .replace('{group}', parsedArgs.group.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Group\GroupController::destroy
* @see app/Http/Controllers/Group/GroupController.php:83
* @route '/group/{group}'
*/
destroy.delete = (args: { group: string | { slug: string } } | [group: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\Group\AcceptInviteController::__invoke
* @see app/Http/Controllers/Group/AcceptInviteController.php:20
* @route '/group/approve-invitation/{token}'
*/
export const approve = (args: { token: string | number } | [token: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: approve.url(args, options),
    method: 'get',
})

approve.definition = {
    methods: ["get","head"],
    url: '/group/approve-invitation/{token}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Group\AcceptInviteController::__invoke
* @see app/Http/Controllers/Group/AcceptInviteController.php:20
* @route '/group/approve-invitation/{token}'
*/
approve.url = (args: { token: string | number } | [token: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { token: args }
    }

    if (Array.isArray(args)) {
        args = {
            token: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        token: args.token,
    }

    return approve.definition.url
            .replace('{token}', parsedArgs.token.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Group\AcceptInviteController::__invoke
* @see app/Http/Controllers/Group/AcceptInviteController.php:20
* @route '/group/approve-invitation/{token}'
*/
approve.get = (args: { token: string | number } | [token: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: approve.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Group\AcceptInviteController::__invoke
* @see app/Http/Controllers/Group/AcceptInviteController.php:20
* @route '/group/approve-invitation/{token}'
*/
approve.head = (args: { token: string | number } | [token: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: approve.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\Group\GroupController::updateImages
* @see app/Http/Controllers/Group/GroupController.php:94
* @route '/group/update-images/{group}'
*/
export const updateImages = (args: { group: string | { slug: string } } | [group: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: updateImages.url(args, options),
    method: 'post',
})

updateImages.definition = {
    methods: ["post"],
    url: '/group/update-images/{group}',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Group\GroupController::updateImages
* @see app/Http/Controllers/Group/GroupController.php:94
* @route '/group/update-images/{group}'
*/
updateImages.url = (args: { group: string | { slug: string } } | [group: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions) => {
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

    return updateImages.definition.url
            .replace('{group}', parsedArgs.group.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Group\GroupController::updateImages
* @see app/Http/Controllers/Group/GroupController.php:94
* @route '/group/update-images/{group}'
*/
updateImages.post = (args: { group: string | { slug: string } } | [group: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: updateImages.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Group\InviteController::__invoke
* @see app/Http/Controllers/Group/InviteController.php:19
* @route '/group/invite/{group}'
*/
export const invite = (args: { group: string | { slug: string } } | [group: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: invite.url(args, options),
    method: 'post',
})

invite.definition = {
    methods: ["post"],
    url: '/group/invite/{group}',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Group\InviteController::__invoke
* @see app/Http/Controllers/Group/InviteController.php:19
* @route '/group/invite/{group}'
*/
invite.url = (args: { group: string | { slug: string } } | [group: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions) => {
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

    return invite.definition.url
            .replace('{group}', parsedArgs.group.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Group\InviteController::__invoke
* @see app/Http/Controllers/Group/InviteController.php:19
* @route '/group/invite/{group}'
*/
invite.post = (args: { group: string | { slug: string } } | [group: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: invite.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Group\JoinController::__invoke
* @see app/Http/Controllers/Group/JoinController.php:17
* @route '/group/join/{group}'
*/
export const join = (args: { group: string | { slug: string } } | [group: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: join.url(args, options),
    method: 'post',
})

join.definition = {
    methods: ["post"],
    url: '/group/join/{group}',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Group\JoinController::__invoke
* @see app/Http/Controllers/Group/JoinController.php:17
* @route '/group/join/{group}'
*/
join.url = (args: { group: string | { slug: string } } | [group: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions) => {
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

    return join.definition.url
            .replace('{group}', parsedArgs.group.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Group\JoinController::__invoke
* @see app/Http/Controllers/Group/JoinController.php:17
* @route '/group/join/{group}'
*/
join.post = (args: { group: string | { slug: string } } | [group: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: join.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Group\ApprovedRequestController::__invoke
* @see app/Http/Controllers/Group/ApprovedRequestController.php:18
* @route '/group/approve/{group}'
*/
export const approveRequest = (args: { group: string | { slug: string } } | [group: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: approveRequest.url(args, options),
    method: 'post',
})

approveRequest.definition = {
    methods: ["post"],
    url: '/group/approve/{group}',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Group\ApprovedRequestController::__invoke
* @see app/Http/Controllers/Group/ApprovedRequestController.php:18
* @route '/group/approve/{group}'
*/
approveRequest.url = (args: { group: string | { slug: string } } | [group: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions) => {
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

    return approveRequest.definition.url
            .replace('{group}', parsedArgs.group.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Group\ApprovedRequestController::__invoke
* @see app/Http/Controllers/Group/ApprovedRequestController.php:18
* @route '/group/approve/{group}'
*/
approveRequest.post = (args: { group: string | { slug: string } } | [group: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: approveRequest.url(args, options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\Group\DestroyUserController::__invoke
* @see app/Http/Controllers/Group/DestroyUserController.php:19
* @route '/group/destroy-user/{group}'
*/
export const destroyUser = (args: { group: string | { slug: string } } | [group: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroyUser.url(args, options),
    method: 'delete',
})

destroyUser.definition = {
    methods: ["delete"],
    url: '/group/destroy-user/{group}',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\Group\DestroyUserController::__invoke
* @see app/Http/Controllers/Group/DestroyUserController.php:19
* @route '/group/destroy-user/{group}'
*/
destroyUser.url = (args: { group: string | { slug: string } } | [group: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions) => {
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

    return destroyUser.definition.url
            .replace('{group}', parsedArgs.group.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Group\DestroyUserController::__invoke
* @see app/Http/Controllers/Group/DestroyUserController.php:19
* @route '/group/destroy-user/{group}'
*/
destroyUser.delete = (args: { group: string | { slug: string } } | [group: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroyUser.url(args, options),
    method: 'delete',
})

/**
* @see \App\Http\Controllers\Group\ChangeRoleController::__invoke
* @see app/Http/Controllers/Group/ChangeRoleController.php:19
* @route '/group/change-role/{group}'
*/
export const changeRole = (args: { group: string | { slug: string } } | [group: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: changeRole.url(args, options),
    method: 'post',
})

changeRole.definition = {
    methods: ["post"],
    url: '/group/change-role/{group}',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Group\ChangeRoleController::__invoke
* @see app/Http/Controllers/Group/ChangeRoleController.php:19
* @route '/group/change-role/{group}'
*/
changeRole.url = (args: { group: string | { slug: string } } | [group: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions) => {
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

    return changeRole.definition.url
            .replace('{group}', parsedArgs.group.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Group\ChangeRoleController::__invoke
* @see app/Http/Controllers/Group/ChangeRoleController.php:19
* @route '/group/change-role/{group}'
*/
changeRole.post = (args: { group: string | { slug: string } } | [group: string | { slug: string } ] | string | { slug: string }, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: changeRole.url(args, options),
    method: 'post',
})

const group = {
    store,
    show,
    update,
    destroy,
    approve,
    updateImages,
    invite,
    join,
    approveRequest,
    destroyUser,
    changeRole,
}

export default group