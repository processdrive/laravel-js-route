@php
    //Read JSON file
    $data = file_get_contents(storage_path().'/routes.json');
@endphp

<script>
    /** 
     * [Description] This is function is helps to get url from laravel route
     * [Params 1] Key_value is route name 
     * [Params 2] params is parameter for route it is optional
     * [Params 3] query paramter for route it is optional
    */
    function route(key_value = false, params = {}, query_params = {})
    {
        try {
            var json_data   = {!! json_encode($data, JSON_HEX_TAG) !!}
            var key         = key_value.replaceAll(".", "")
            var result      = JSON.parse(json_data)
            var base_url    = window.location.origin
            
            if (!result[key]) {
                console.log(`Please check the route name : ${key_value}`)
                return false
            }

            if (params)  url = setParams(result[key], params)

            if (query_params) var convert_as_query_params = new URLSearchParams(query_params)
            
            var return_data = url ? `${base_url}/${url}` : `${base_url}/${result[key]}`
            return (params && convert_as_query_params.toString()) ? `${return_data}?${convert_as_query_params.toString()}` : return_data
            
        } catch (err) {
            console.log('something went wrong..!');
        }
    }


    /** 
     * [Description] This is function is helps to set parameters
     * [Params 1] url 
     * [Params 2] params is parameter for route it is optional
    */
    function setParams(url, params) {
        let result_array = []
        let reg_expression = /[{}]+/;
        let reg_expression_optional = /[?]+/;
        url.split('/').forEach(element => {
            if (reg_expression.test(element)) {
                element = element.replace('{', "")
                element = element.replace('}', "")
                if (reg_expression_optional.test(element)) params[element.replace('?', "")] ? result_array.push(params[element.replace('?', "")]) : ''
                else result_array.push(params[element])
            } else {
                result_array.push(element)
            }
        });
        return result_array.join('/')
    }
</script>
