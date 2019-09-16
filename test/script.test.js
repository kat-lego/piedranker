const puppeteer = require('puppeteer');
const openNav = require("../app/javascript/script.js");
const prepareTable = require("../app/javascript/script.js");
const loadLeaderboard = require("../app/javascript/script.js");
const fillLeaderboard =  require("../app/javascript/script.js");
test("Test OpenNav", async ()=>{

	//test if document.getElementById("mySidenav").style.width = "25%" when you click the nav

    const browser = await puppeteer.launch({
        headless: true,
        // slowMo:80,
        // args: ["--window-size=1920,1080"]
    });

    const page = await browser.newPage();
    await page.goto('http://1710409.ms.wits.ac.za/piedranker/app/php/rankings.php?assignid=83&courseid=15');
    await page.click(".sidenav_icon");
    const a = await page.$eval('.sidenav', el=>el.style.width);
    expect(a).toBe("25%");


}, 10000);

test("Test CloseNav", async ()=>{
	//test if document.getElementById("mySidenav").style.width = "0" when you click the x button
    // const browser = await puppeteer.launch({
    //     headless: true,
    //     // slowMo:80,
    //     // args: ["--window-size=1920,1080"]
    // });

    // const page = await browser.newPage();
    // await page.goto('http://1710409.ms.wits.ac.za/piedranker/app/php/rankings.php?assignid=83&courseid=15');
    // await page.click(".closebtn");
    // const a = await page.$eval('.sidenav', el=>el.style.width);
    // expect(a).toBe("0%");



},10000);

test("Test fillTitle", async ()=>{
	// 1- when the page loads, the tittle should have the assignment name and assignment mode
    const browser = await puppeteer.launch({
        headless: true,
        // slowMo:80,
        // args: ["--window-size=1920,1080"]
    });

    const page = await browser.newPage();
    await page.goto('http://1710409.ms.wits.ac.za/piedranker/app/php/rankings.php?assignid=83&courseid=15');
    
    const a = await page.$eval('.title', el=>el.innerText);
    expect(a).toBe("TUNA\nFastest Mode");


	// 2- When you open the nav and click on a course, its respective assignment name and assignment mode should appear.
    // await page.click(".sidenav_icon");
    // const a2 = await page.$eval('.sidenav', el=>console.log(el));
    // await page.click("#90");

},10000);

test("Test fillNav", async ()=>{
    const browser = await puppeteer.launch({
        headless: true,
        // slowMo:80,
        // args: ["--window-size=1920,1080"]
    });

    const page = await browser.newPage();
    await page.goto('http://1710409.ms.wits.ac.za/piedranker/app/php/rankings.php?assignid=83&courseid=15');
    
    const a = await page.$eval('.sidenav', el=>el.innerText);
    expect(a).toBe("×\nFIXED\nTUNA\nlab4\njava test\nPythonZip Test\nlets\ntest1\nzip python");
	
},10000);

test("Test loadLeaderboard", async ()=>{

    // const browser = await puppeteer.launch({
    //     headless: true,
    //     // slowMo:80,
    //     // args: ["--window-size=1920,1080"]
    // });

    // const page = await browser.newPage();
    // await page.goto('http://1710409.ms.wits.ac.za/piedranker/app/php/rankings.php?assignid=83&courseid=15');
    loadLeaderboard(83);
});

