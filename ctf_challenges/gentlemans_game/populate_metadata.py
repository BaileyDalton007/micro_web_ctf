import random
import re

# Lists of random options
players = [
    "Ronald", "Brian", "Harold", "Vipin", "An", "Mark"]

events = [
    "World Chess Championship", "Tata Steel Chess Tournament", 
    "FIDE Grand Prix", "Norway Chess", "Sinquefield Cup", 
    "Chess Olympiad", "Candidates Tournament", "Grand Chess Tour", 
    "Gibraltar Chess Festival"
]

def populate_pgn_fields(pgn_content):
    # Split the PGN content into individual games
    games = pgn_content.split('\n[Event')
    
    # If the file starts with [Event, we need to handle the first game differently
    if not games[0].startswith('['):
        games[0] = '[Event' + games[0]
    else:
        games = [games[0]] + ['[Event' + g for g in games[1:]]
    
    populated_games = []
    
    for game in games:
        if not game.strip():
            continue
            
        # Randomly select values

        white = None
        black = None
        opp = random.choice(players)
        me = "Bailey"	

        random_bit = random.randint(0,1)
        if random_bit == 0:
            white = me
            black = opp
        else:
            white = opp
            black = me
	

        event = random.choice(events)
        
        # Replace the placeholders
        game = re.sub(r'\[White "(.*)"\]', f'[White "{white}"]', game)
        game = re.sub(r'\[Black "(.*)"\]', f'[Black "{black}"]', game)
        game = re.sub(r'\[Event "(.*)"\]', f'[Event "{event}"]', game)
        
        populated_games.append(game)
    
    # Join the games back together
    return '\n\n'.join(populated_games)

# Example usage
if __name__ == "__main__":
    # Read the PGN file
    with open('games.pgn', 'r') as file:
        pgn_content = file.read()
    
    # Populate the fields
    populated_pgn = populate_pgn_fields(pgn_content)
    
    # Write the populated PGN back to a file
    with open('games.pgn', 'w') as file:
        file.write(populated_pgn)
    
    print("PGN fields have been populated successfully!")
