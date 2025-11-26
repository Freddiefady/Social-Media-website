import { queryParams, type RouteQueryOptions, type RouteDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Posts\UrlPreviewController::__invoke
* @see app/Http/Controllers/Posts/UrlPreviewController.php:19
* @route '/post/url-preview'
*/
const UrlPreviewController = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: UrlPreviewController.url(options),
    method: 'post',
})

UrlPreviewController.definition = {
    methods: ["post"],
    url: '/post/url-preview',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Posts\UrlPreviewController::__invoke
* @see app/Http/Controllers/Posts/UrlPreviewController.php:19
* @route '/post/url-preview'
*/
UrlPreviewController.url = (options?: RouteQueryOptions) => {
    return UrlPreviewController.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Posts\UrlPreviewController::__invoke
* @see app/Http/Controllers/Posts/UrlPreviewController.php:19
* @route '/post/url-preview'
*/
UrlPreviewController.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: UrlPreviewController.url(options),
    method: 'post',
})

export default UrlPreviewController