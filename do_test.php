<script>

function shuffle(array) {
  let currentIndex = array.length,  randomIndex;

  // While there remain elements to shuffle.
  while (currentIndex != 0) {

    // Pick a remaining element.
    randomIndex = Math.floor(Math.random() * currentIndex);
    currentIndex--;

    // And swap it with the current element.
    [array[currentIndex], array[randomIndex]] = [
      array[randomIndex], array[currentIndex]];
  }

  return array;
}

// Used like so
let questions = [
    {
        tblAutoId: 1,
        numb: 1,
        question: "Aesthetic' term was first used in the branch of",
        answer: "all of the above",
        answer_digit: "4",
        options: [
            "Philosophy ",
            "Science",
            "Maths",
            "all of the above"
        ]
    },
    {
        tblAutoId: 33,
        numb: 2,
        question: "Non realistic art is known as????..",
        answer: "abstract",
        answer_digit: "2",
        options: [
            "surrealism",
            "abstract",
            "cubism",
            "realism"
        ]
    },
    {
        tblAutoId: 34,
        numb: 3,
        question: "???..style is the artist uses geometric shapes to show what he is trying to paint.",
        answer: "realism",
        answer_digit: "4",
        options: [
            "pop art",
            "impressionism",
            "abstract",
            "realism"
        ]
    },
    {
        tblAutoId: 35,
        numb: 4,
        question: "Petroglyphs are ",
        answer: "realism",
        answer_digit: "4",
        options: [
            "Images incised in rock",
            "Paintings on rocks",
            "Blocks",
            "Carvings in Temples"
        ]
    },
    {
        tblAutoId: 36,
        numb: 5,
        question: "The great intellectual movement of Renaissance Italy was ",
        answer: "humanism",
        answer_digit: "4",
        options: [
            "cubism",
            "groupism",
            "fascism",
            "humanism"
        ]
    },
    {
        tblAutoId: 37,
        numb: 6,
        question: "A scriptorium is ??.",
        answer: "a room devoted to the handlettered copying of manuscripts",
        answer_digit: "2",
        options: [
            "letter forms",
            "a room devoted to the handlettered copying of manuscripts",
            "the artist who scripted the books",
            "A stylized script"
        ]
    },
    {
        tblAutoId: 38,
        numb: 7,
        question: "The word paper comes from",
        answer: "the ancient Egyptian writing material called papyrus",
        answer_digit: "1",
        options: [
            "the ancient Egyptian writing material called papyrus",
            "Pepper",
            "Petals",
            "None of these"
        ]
    },
    {
        tblAutoId: 39,
        numb: 8,
        question: "What did Johann Gutenberg invent?",
        answer: "Movable type Printing Press",
        answer_digit: "2",
        options: [
            "Telescope",
            "Movable type Printing Press",
            "Movable machines",
            "Beats"
        ]
    },
    {
        tblAutoId: 40,
        numb: 9,
        question: "What is metacognition?",
        answer: "thinking about your thinking",
        answer_digit: "2",
        options: [
            "creating mental images in your mind",
            "thinking about your thinking",
            "wondering as you read",
            "thinking what the text might be about"
        ]
    },
    {
        tblAutoId: 41,
        numb: 10,
        question: "Self-awareness as a leaner?",
        answer: "Understands the relationship between ones emotions thoughts values and behaviors",
        answer_digit: "3",
        options: [
            "Understands strengths and weakness ",
            "Identifies ones emotions and how they affect others",
            "Understands the relationship between ones emotions thoughts values and behaviors",
            "All of the above"
        ]
    },
];

var arr = [2, 11, 37, 42];
shuffle(questions);
console.log(questions);

</script>