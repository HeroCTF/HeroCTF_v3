from flask import Flask, render_template, request
from flask_classful import FlaskView, route
import dis
app = Flask(__name__)
port = 8050
def secret_function():
    flag = "Hero{l34k_my_byt3c0d3zzzzzz}"
    return flag

class App(FlaskView):
    def __init__(self):
        self.content = ""

    def index(self):
        return render_template("index.html")

    @route("/try", methods=["GET","POST"])
    def get_results(self):
        if(request.method == "GET"):
            return render_template("try.html")
        else:
            try:
                params = request.form.to_dict(flat=False)
                if(params["title"] and params["content"]):
                    title = params["title"][0]
                    self.content = params["content"][0]
                    ret = f"<!DOCTYPE html><head><title>"+title+f"</title></head><body>{self.content}</body></html>".format(self=self)
                    return ret
                else:
                    return "Missing parameters!"
            except Exception as e:
                print(e)
                return "Something went wrong, sorry! It's only the alpha version !"

App.register(app,route_base="/")
if __name__ == "__main__":
    app.run(host="0.0.0.0",port=port)
