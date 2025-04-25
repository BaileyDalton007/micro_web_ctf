<?php
// Create (or open) the database file
$db = new SQLite3('assets/posts.db');

// Create users table
$db->exec("CREATE TABLE IF NOT EXISTS posts (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    post_title TEXT NOT NULL,
    post_content TEXT NOT NULL,
    author TEXT NOT NULL,
    image_path TEXT NULL
)");

// create the posts (many are LLM generated with no proofreading)
$posts = [
    ["Welcome my sheep", "Lebron", "Welcome to my house my LeChildren", "lebron_portrait.jpg"],
    ['LeBron: The GOAT', 'KingJamesFan42', 'LeBron James is undoubtedly the greatest player to ever grace the basketball court. His accolades speak for themselves, and every time he steps on the floor, it’s pure magic. I truly believe we’re witnessing the best of all time right in front of our eyes. The way he continues to dominate at his age is unprecedented. Who agrees with me that LeBron is the GOAT?', null],
    ['The Legacy of LeBron: More Than Just Basketball', 'LeBron4Life23', 'LeBron is more than just an athlete – he’s a cultural icon. The impact he has on society, especially with his charitable work, has cemented his legacy in ways that go beyond basketball. His foundation is helping to change lives, and he’s always striving to be a role model for the next generation. LeBron will forever be a symbol of greatness, both on and off the court.', 'layup.jpg'],
    ['LeBron vs MJ: The Ultimate Debate', 'BronnyFan', 'I know we all have our opinions, but I think we can all agree that comparing LeBron to Michael Jordan is a debate that will never end. While MJ revolutionized the game and built his dynasty in the \'90s, LeBron’s ability to adapt and still perform at an elite level in today\'s NBA is unmatched. What do you all think? LeBron’s longevity and versatility make him the clear GOAT in my book.', null],
    ['LeBron’s Best Finals Performance', 'HoopsMaster21', 'After watching LeBron’s performance in Game 5 of the 2016 Finals, I am convinced that no one else could have done what he did. That block on Andre Iguodala, the clutch shots, and leading the Cavs to a historic comeback – that moment is cemented in history. I honestly don’t think we’ll ever see a player do something like that again. Truly a once-in-a-lifetime performance!', 'leCav.jpg'],
    ['LeBron James: A King Off the Court', 'BasketballGuru', 'LeBron’s contributions to the world extend far beyond the basketball court. The way he’s used his platform to speak out on social issues, his commitment to education with the “I PROMISE” school, and his constant efforts to uplift his community are nothing short of inspiring. LeBron is a king both on and off the court, and his influence will be felt for generations to come.', 'leKing.jpg'],
    ['Why LeBron Should Stay in LA Forever', 'Guest', 'As a Lakers fan, I truly hope LeBron stays with the Lakers for the rest of his career. His leadership on and off the court has been pivotal to the team’s success, and I believe he can bring more championships to LA. The city has embraced him as one of its own, and there’s no better place for him to finish his legendary career than Los Angeles.', null],
    ['LeBron and the Next Generation', 'YoungHoopsFan', 'LeBron has done so much for the NBA, and now he’s starting to mentor the next generation of superstars. Watching him help players like Anthony Davis and rookie talents grow has been incredible. He’s passing the torch to the young guys while still dominating the game himself. I can’t wait to see how his legacy shapes the future of basketball!', 'leSilly.jpg'],
    ['The Best LeBron Moment Ever!', 'CavsForever', 'For me, the best LeBron moment ever was his Game 7 performance against the Warriors in the 2016 Finals. He delivered when it mattered most, bringing a championship to Cleveland for the first time in history. The emotion and the magnitude of that moment made it unforgettable. LeBron’s greatness was on full display, and I don’t think anyone will ever forget that historic win.', null],
    ['LeBron’s Insane Physicality and Skill', 'BigFan22', 'LeBron’s combination of size, strength, and skill is simply ridiculous. He’s 6’9” and 250 lbs, yet he moves like a guard. His ability to finish in traffic, his court vision, and his athleticism are something we’ve never seen before. He’s built like a freight train but has the finesse of a ballet dancer. How does he do it?! The way he defies age is truly mind-blowing.',null],
    ['LeBron’s Greatest Rivalries', 'NBAHistorian', 'One thing that stands out about LeBron’s career is the intensity of his rivalries. From his fierce battles against the Warriors in the Finals to his rivalry with Paul George and the Pacers in the East, LeBron has faced some of the toughest competition ever. Those matchups defined an era of basketball. What rivalry do you think defined LeBron’s career the most? For me, it’s his back-and-forth with the Warriors in the 2010s.', 'leScream.jpg'],
    ['LeBron is the Perfect Role Model', 'Guest', 'LeBron James has always been an inspiration for young athletes. Not only for his incredible work ethic and perseverance, but for the way he carries himself off the court. He’s humble, generous, and deeply passionate about giving back. He’s shown us that you can be a superstar and still be a good person, which is why he’s not just a sports icon – he’s a role model for all of us.', 'leCrashout.jpg']
];

// add each post to the db
foreach ($posts as $post) {
    $title = $post[0];
    $author = $post[1];
    $content = $post[2];
    $image_path = $post[3];

    $stmt = $db->prepare("INSERT INTO posts (post_title, post_content, author, image_path) VALUES (:post_title, :post_content, :author, :image_path)");
    $stmt->bindValue(':post_title', $title, SQLITE3_TEXT);
    $stmt->bindValue(':post_content', $content, SQLITE3_TEXT);
    $stmt->bindValue(':author', $author, SQLITE3_TEXT);
    $stmt->bindValue(':image_path', $image_path, SQLITE3_TEXT);
    $stmt->execute();
}
echo "Database created and posts inserted into posts.db\n";

