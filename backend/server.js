const express = require('express');
const config = require('./config');

const app = express();
const port = 3000;

app.use(express.json());

app.get('/api/config', (req, res) => {
    res.json(config);
});

app.listen(port, () => {
    console.log(`Server is running on http://localhost:${port}`);
});
