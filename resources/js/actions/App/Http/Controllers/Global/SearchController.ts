import { queryParams, type RouteQueryOptions, type RouteDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Global\SearchController::__invoke
* @see app/Http/Controllers/Global/SearchController.php:33
* @route '/search/{search}'
*/
const SearchController = (args: { search: string | number } | [search: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: SearchController.url(args, options),
    method: 'get',
})

SearchController.definition = {
    methods: ["get","head"],
    url: '/search/{search}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Global\SearchController::__invoke
* @see app/Http/Controllers/Global/SearchController.php:33
* @route '/search/{search}'
*/
SearchController.url = (args: { search: string | number } | [search: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { search: args }
    }

    if (Array.isArray(args)) {
        args = {
            search: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        search: args.search,
    }

    return SearchController.definition.url
            .replace('{search}', parsedArgs.search.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Global\SearchController::__invoke
* @see app/Http/Controllers/Global/SearchController.php:33
* @route '/search/{search}'
*/
SearchController.get = (args: { search: string | number } | [search: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: SearchController.url(args, options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\Global\SearchController::__invoke
* @see app/Http/Controllers/Global/SearchController.php:33
* @route '/search/{search}'
*/
SearchController.head = (args: { search: string | number } | [search: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: SearchController.url(args, options),
    method: 'head',
})

export default SearchController