# Faceting

# (a)
curl -XGET 'http://localhost:9200/rdu/beer/_search?pretty=' -d '
{
    "query" : {
        "match_all" : { }
    },
    "facets": {
        "style": {
            "terms": {
                "field": "style.untouched"
            }
        }
    }
}
'

# (b)
curl -XGET 'http://localhost:9200/rdu/beer/_search?pretty=' -d '
{
    "query" : {
        "match_all" : { }
    },
    "filter" : {
        "term" : {
            "style.untouched" : "American-Style Brown Ale"
        }
    },
    "facets": {
        "style": {
            "terms": {
                "field": "style.untouched"
            }
        }
    }
}
'

# (c)
curl -XGET 'http://localhost:9200/rdu/beer/_search?pretty=' -d '
{
    "query" : {
        "match_all" : { }
    },
    "filter" : {
        "term" : {
            "style.untouched" : "American-Style Brown Ale"
        }
    },
    "facets": {
        "style": {
            "terms": {
                "field": "style.untouched"
            },
            "facet_filter" : {
                "term" : {
                    "style.untouched" : "American-Style Brown Ale" 
                }
            }
        }
    }
}
'