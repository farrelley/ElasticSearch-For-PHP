# Query and Filter by Geo Distance

# Raleigh, NC PHP - Tek Systems (1201 Edwards Mill Rd. , Ste 201 Raleigh, North Carolina 27607)
# 35.799341,-78.728328

curl -XGET 'http://localhost:9200/rdu/brewery/_search?pretty=true' -d '
{
    "query" : {
        "match_all" : {}
    },
    "filter" : {
        "geo_distance" : {
            "distance" : "5mi",
            "brewery.location.address.geo" : {
                "lat" : 35.799341,
                "lon" : -78.728328
            }
        }
    }
}
'