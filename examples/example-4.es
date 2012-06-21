# Query and Filter

curl -XGET 'http://localhost:9200/rdu/beer/_search?pretty=' -d '
{
    "query" : {
        "term" : { 
            "style.untouched" : "American-Style Pale Ale" 
        }
    },
    "filter" : {
        "term" : {
            "brewery.name" : "Lonerider Brewing Company"
        }
    }
}
'