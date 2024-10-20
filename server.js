// Express is for creating the server
const express = require("express")
// Multer is for handling multi-media
const multer = require("multer")
// Path built into Node.JS, this is for working with file and directory paths
const path = require("path")
// FS also a built in module in Node.JS, this is for interacting with the file system
const fs = require("fs")
// util is for accessing utulity functions (ex. unlinkFile)
const util = require("util")
// unlinkFile is for unlinking files in the file system
const unlinkFile = util.promisify(fs.unlink)

const storage = multer.diskStorage({

    // destination lets us choose a folder where we want to store the images
    destination: function (req, file, cb) {
      cb(null, '/public/uploads/')
    },

    //filename let's us choose a file name for each one of the images
    filename: function (req, file, cb) {
      const uniqueSuffix = Date.now() + '-' + Math.round(Math.random() * 1E9)
      // Using the unique suffix plus the filename
      cb(null, uniqueSuffix + path.extname(file.originalname))
    }
})
  
const upload = multer({ 
    storage: storage,
    limits: {fileSize:5000000},

    fileFilter: function(req, file, cb){
        checkFileType(file, cb)
    }

    // .any() allows user to upload multiple files
}).any()

function checkFileType (file, cb) {

    const fileTypes = /jpeg|png|jpg/
    const extname = fileTypes.test(path.extname(file.originalname).toLowerCase())
    // Check the mimetype of the file coming in
    const mimetype = fileTypes.test(file.mimetype)

    // extname & mimetype have true or false variables depending on if they are these kind filetypes

    if(mimetype && extname){
        return cb(null, true)
    } else {
        cb("Please upload images only")
    }
  
}

const port = 3000

const app = express()

app.use(express.json())
app.use(express.urlencoded({extended:false}))

app.set("view engine", "ejs")

app.use(express.static("public"))

// Create a get route to render the index.ejs file

app.get("/", (req, res) => {

    res.render("index")

})

app.post("/upload", (req, res) => {
    
    upload(req, res, (err) => {

        //Check for user test path, if the user didn't upload anything, and if there was an error
        if (!err && req.files != ""){

            res.status(200).send() //This is the good response we want to send to front end

        } else if (!err && req.files == ""){

            res.statusMessage = "Please select an image to upload"

        } else if (err) {

            res.statusMessage = (err == "Please upload images only") ? err : "Photo exceed limit of 5 MB"
            res.status(400).end()

        }

    })

})

app.listen(port, () => {

    console.log(`Server started on port ${port}`)

})