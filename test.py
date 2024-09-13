
import requests
import json

url = 'http://yourURL/graphql'
headers = {'Content-Type': 'application/json'}
data = {"query":"query { echo(message: \"Hello, World!\")}"}
id_wrapper = [0]

def testQuery(url,headers,data, id):
    id[0] += 1
    response = requests.post(url, headers=headers, json=data)
    print(f"Test {id[0]}:")
    print(response.status_code)
    print(response.text)
    try:
        resultjson = json.loads(response.text)
        with open(f'result-{id[0]}.json', 'w+') as f:
            json.dump(resultjson, f, indent=4)
        return resultjson
    except:
        with open(f'result-{id[0]}.json', 'w+') as f:
            f.write(response.text)
        return None
    


def build_creation_command(product):
    creationCommand = "create_"+product["id"].replace("-","_")+": createProduct(input: {"
    creationCommand += "id: \"" + product["id"] + "\","
    creationCommand += "name: \"" + product["name"] + "\","
    creationCommand += "inStock: " + str(product["inStock"]).lower() + ","  # Convert to lowercase for booleans
    creationCommand += "description: \"" + product["description"] + "\","
    creationCommand += "category: \"" + product["category"] + "\","
    
    # Attributes
    if product.get("attributes"):
        creationCommand += "attributes: ["
        for attribute in product["attributes"]:
            creationCommand += "{"
            creationCommand += "id: \"" + attribute["id"] + "\","
            creationCommand += "name: \"" + attribute["name"] + "\","
            creationCommand += "type: \"" + attribute["type"] + "\","
            creationCommand += "items: ["
            for item in attribute["items"]:
                creationCommand += "{"
                creationCommand += "id: \"" + item["id"] + "\","
                creationCommand += "displayValue: \"" + item["displayValue"] + "\","
                creationCommand += "value: \"" + item["value"] + "\""
                creationCommand += "},"
            creationCommand = creationCommand.rstrip(",")  # Remove trailing comma
            creationCommand += "]"
            creationCommand += "},"
        creationCommand = creationCommand.rstrip(",")  # Remove trailing comma
        creationCommand += "],"
    else:
        creationCommand += "attributes: [],"
    
    # Prices
    if product.get("prices"):
        creationCommand += "prices: ["
        for price in product["prices"]:
            creationCommand += "{"
            creationCommand += "amount: " + str(price["amount"]) + ","
            creationCommand += "currency: {"
            creationCommand += "label: \"" + price["currency"]["label"] + "\","
            creationCommand += "symbol: \"" + price["currency"]["symbol"] + "\""
            creationCommand += "}"
            creationCommand += "},"
        creationCommand = creationCommand.rstrip(",")  # Remove trailing comma
        creationCommand += "],"
    else:
        creationCommand += "prices: [],"
    
    # Brand
    creationCommand += "brand: \"" + product["brand"] + "\","
    
    # Gallery
    if product.get("gallery"):
        creationCommand += "gallery: ["
        for image in product["gallery"]:
            creationCommand += "\"" + image + "\","
        creationCommand = creationCommand.rstrip(",")  # Remove trailing comma
        creationCommand += "]"
    else:
        creationCommand += "gallery: []"
    
    creationCommand += "}) "
    return creationCommand








# testQuery(url,headers,data,id_wrapper)
# data = {"query":"mutation { sum(x: 2, y: 3) }"}
# testQuery(url,headers,data,id_wrapper)
# data = { "query": "query { hello { hello } }"}
# testQuery(url,headers,data,id_wrapper)
# data = { "query": "query { product { echo(message: \"Hello, World!\") } }"}
# testQuery(url,headers,data,id_wrapper)
# data = { "query": "mutation { createCategory(name: \"New Category\") }"}
# testQuery(url,headers,data,id_wrapper)
# data = { "query": "mutation { createCategory(name: \"testName\") }"}
# testQuery(url,headers,data,id_wrapper)
# data = { "query": "query { category (name:\"New Category\") { id name } }"}
# deletableId = testQuery(url,headers,data,id_wrapper)["data"]["category"]["id"]
# data = { "query": "mutation { updateCategory(id:"+str(deletableId)+",name: \"New Name\") }"}
# testQuery(url,headers,data,id_wrapper)
# data = { "query": "query { category (name:\"clothes\") { id name } }"}
# testQuery(url,headers,data,id_wrapper)
# data = { "query": "query { categories { id name } }"}
# testQuery(url,headers,data,id_wrapper)
# data = { "query": "query { category (id:2) { id name } }"}
# testQuery(url,headers,data,id_wrapper)
#data = { "query": "mutation { deleteCategory (name: \"testName\") }"}
#testQuery(url,headers,data,id_wrapper)
#data = { "query": "mutation { deleteCategory (id: "+str(deletableId)+") }"}
#testQuery(url,headers,data,id_wrapper)


data = {
    "query": "mutation { "
}
inputData = {}
with open('data.json', 'r') as f:
    inputData = json.load(f)
inputData = inputData["data"]["products"]

i = 1 
for product in inputData:
    data["query"] += build_creation_command(product)
data["query"] += "}"
data["query"] = data["query"].replace("\n","\\n")

with open('test.txt', 'w+') as f:
    f.write(str(data))






# data = {
#   "query": "mutation { createProduct(input: { id: \"huarache-x-stussy-le\", name: \"Nike Air Huarache Le\", inStock: true, description: \"<p>Great sneakers for everyday use!</p>\", category: \"clothes\", attributes: [ { id: \"Size\", items: [ { displayValue: \"40\", value: \"40\", id: \"40\" }, { displayValue: \"41\", value: \"41\", id: \"41\" }, { displayValue: \"42\", value: \"42\", id: \"42\" }, { displayValue: \"43\", value: \"43\", id: \"43\" } ], name: \"Size\", type: \"text\" } ], prices: [ { amount: 144.69, currency: { label: \"USD\", symbol: \"$\" } } ], brand: \"Nike x Stussy\", gallery: [ \"https://cdn.shopify.com/s/files/1/0087/6193/3920/products/DD1381200_DEOA_2_720x.jpg?v=1612816087\", \"https://cdn.shopify.com/s/files/1/0087/6193/3920/products/DD1381200_DEOA_1_720x.jpg?v=1612816087\", \"https://cdn.shopify.com/s/files/1/0087/6193/3920/products/DD1381200_DEOA_3_720x.jpg?v=1612816087\", \"https://cdn.shopify.com/s/files/1/0087/6193/3920/products/DD1381200_DEOA_5_720x.jpg?v=1612816087\", \"https://cdn.shopify.com/s/files/1/0087/6193/3920/products/DD1381200_DEOA_4_720x.jpg?v=1612816087\" ] }) }"
# }

print(data)
testQuery(url,headers,data,id_wrapper)





# data = {
#   "query": "query { products { id name inStock description category attributes { id name type items { id displayValue value } } prices { amount currency { label symbol } } brand gallery } }"
# }
# testQuery(url,headers,data,id_wrapper)
