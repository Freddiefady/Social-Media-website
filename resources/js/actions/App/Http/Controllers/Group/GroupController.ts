import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
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

const GroupController = { store, show, update, destroy, updateImages }

export default GroupController