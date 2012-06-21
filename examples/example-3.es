# Get all breweries

curl -XGET 'http://localhost:9200/rdu/brewery/_search?pretty=' -d '
{
    "query" : {
        "match_all" : { }
    }
}
'