import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Posts\GeneratePostController::__invoke
* @see app/Http/Controllers/Posts/GeneratePostController.php:19
* @route '/post/generate-post'
*/
export const ai = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: ai.url(options),
    method: 'post',
})

ai.definition = {
    methods: ["post"],
    url: '/post/generate-post',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Posts\GeneratePostController::__invoke
* @see app/Http/Controllers/Posts/GeneratePostController.php:19
* @route '/post/generate-post'
*/
ai.url = (options?: RouteQueryOptions) => {
    return ai.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Posts\GeneratePostController::__invoke
* @see app/Http/Controllers/Posts/GeneratePostController.php:19
* @route '/post/generate-post'
*/
ai.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: ai.url(options),
    method: 'post',
})

const generate = {
    ai,
}

export default generate