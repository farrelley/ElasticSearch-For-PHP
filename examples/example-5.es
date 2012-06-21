# Query by Field and By Term


# (a) Search By Term
curl -XGET 'http://localhost:9200/rdu/beer/_search?pretty=' -d '
{
    "query" : {
        "term" : { "style.untouched" : "American-Style Stout" }
    }
}
'

# (b) Search By Field
curl -XGET 'http://localhost:9200/rdu/beer/_search?pretty=' -d '
{
    "query" : {
        "field" : { 
            "style" : "Stout"
        }
    }
}
'

# (c) Search By Field +/-
curl -XGET 'http://localhost:9200/rdu/beer/_search?pretty=' -d '
{
    "query" : {
        "field" : { 
            "style" : "+Stout -Foreign"
        }
    }
}
'