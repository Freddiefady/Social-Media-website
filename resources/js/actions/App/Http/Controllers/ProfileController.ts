import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\ProfileController::index
* @see app/Http/Controllers/ProfileController.php:34
* @route '/u/{user}'
*/
export const index = (args: { user: string | { username: string } } | [user: string | { username: string } ] | string | { username: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(args, options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/u/{user}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\ProfileController::index
* @see app/Http/Controllers/ProfileController.php:34
* @route '/u/{user}'
*/
index.url = (args: { user: string | { username: string } } | [user: string | { username: string } ] | string | { username: string }, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { user: args }
    }

    if (typeof args === 'object' && !Array.isArray(args) && 'username' in args) {
        args = { user: args.username }
    }

    if (Array.isArray(args)) {
        args = {
            user: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        user: typeof args.user === 'object'
        ? args.user.username
        : args.user,
    }

    return index.definition.url
            .replace('{user}', parsedArgs.user.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\ProfileController::index
* @see app/Http/Controllers/ProfileController.php:34
* @route '/u/{user}'
*/
index.get = (args: { user: string | { username: string } } | [user: string | { username: string } ] | string | { username: string }, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\ProfileController::index
* @see app/Http/Controllers/ProfileController.php:34
* @route '/u/{user}'
*/
index.head = (args: { user: string | { username: string } } | [user: string | { username: string } ] | string | { username: string }, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(args, options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\ProfileController::updateImages
* @see app/Http/Controllers/ProfileController.php:107
* @route '/profile/update-images'
*/
export const updateImages = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: updateImages.url(options),
    method: 'post',
})

updateImages.definition = {
    methods: ["post"],
    url: '/profile/update-images',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\ProfileController::updateImages
* @see app/Http/Controllers/ProfileController.php:107
* @route '/profile/update-images'
*/
updateImages.url = (options?: RouteQueryOptions) => {
    return updateImages.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\ProfileController::updateImages
* @see app/Http/Controllers/ProfileController.php:107
* @route '/profile/update-images'
*/
updateImages.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: updateImages.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\ProfileController::update
* @see app/Http/Controllers/ProfileController.php:70
* @route '/profile'
*/
export const update = (options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(options),
    method: 'patch',
})

update.definition = {
    methods: ["patch"],
    url: '/profile',
} satisfies RouteDefinition<["patch"]>

/**
* @see \App\Http\Controllers\ProfileController::update
* @see app/Http/Controllers/ProfileController.php:70
* @route '/profile'
*/
update.url = (options?: RouteQueryOptions) => {
    return update.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\ProfileController::update
* @see app/Http/Controllers/ProfileController.php:70
* @route '/profile'
*/
update.patch = (options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: update.url(options),
    method: 'patch',
})

/**
* @see \App\Http\Controllers\ProfileController::destroy
* @see app/Http/Controllers/ProfileController.php:86
* @route '/profile'
*/
export const destroy = (options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(options),
    method: 'delete',
})

destroy.definition = {
    methods: ["delete"],
    url: '/profile',
} satisfies RouteDefinition<["delete"]>

/**
* @see \App\Http\Controllers\ProfileController::destroy
* @see app/Http/Controllers/ProfileController.php:86
* @route '/profile'
*/
destroy.url = (options?: RouteQueryOptions) => {
    return destroy.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\ProfileController::destroy
* @see app/Http/Controllers/ProfileController.php:86
* @route '/profile'
*/
destroy.delete = (options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: destroy.url(options),
    method: 'delete',
})

const ProfileController = { index, updateImages, update, destroy }

export default ProfileController