import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Posts\GeneratePostController::__invoke
* @see app/Http/Controllers/Posts/GeneratePostController.php:19
* @route '/post/generate-post'
*/
const GeneratePostController = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: GeneratePostController.url(options),
    method: 'post',
})

GeneratePostController.definition = {
    methods: ["post"],
    url: '/post/generate-post',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Posts\GeneratePostController::__invoke
* @see app/Http/Controllers/Posts/GeneratePostController.php:19
* @route '/post/generate-post'
*/
GeneratePostController.url = (options?: RouteQueryOptions) => {
    return GeneratePostController.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Posts\GeneratePostController::__invoke
* @see app/Http/Controllers/Posts/GeneratePostController.php:19
* @route '/post/generate-post'
*/
GeneratePostController.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: GeneratePostController.url(options),
    method: 'post',
})

export default GeneratePostController