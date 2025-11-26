import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../wayfinder'
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

const profile = {
    updateImages,
    update,
    destroy,
}

export default profile