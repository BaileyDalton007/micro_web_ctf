from itertools import product

NBA_TEAMS = [
    "hawks", "celtics", "nets", "hornets", "bulls", "cavaliers", "mavericks",
    "nuggets", "pistons", "warriors", "rockets", "pacers", "clippers", "lakers",
    "grizzlies", "heat", "bucks", "timberwolves", "pelicans", "knicks", "thunder",
    "magic", "sixers", "suns", "blazers", "kings", "spurs", "raptors", "jazz", "wizards"
]

LEET_MAP = {
    'a': ['a', '@', '4'],
    'e': ['e', '3'],
    'i': ['i', '1', '!'],
    'o': ['o', '0'],
    's': ['s', '$', '5'],
    't': ['t', '7'],
    'l': ['l', '1']
}

def capitalization_teams(teams):
   output = []
   for team in teams:
      output = output + [team, team.upper()]

   return output

def leetspeak_variations(word):
    # Get a list of possible substitutions for each character
    choices = [LEET_MAP.get(c.lower(), [c]) for c in word]

    # Generate the cartesian product of all character choices
    return [''.join(variant) for variant in product(*choices)]

def leetspeak_teams(teams):
   output = []
   for team in teams:
      new_variations = leetspeak_variations(team)
      output = output + new_variations

   return output

def add_nums(words):
   output = list(words)
   for j, word in enumerate(words):
      print(str(j) +"/"+str(len(words)))

      # add nums 0-99
      for i in range(100):
         output.append(word+str(i))

      # add nums 00-09
      for i in range(10):
         output.append(word+"0"+str(i))

   return output


# Example usage
leet_vars = leetspeak_teams(NBA_TEAMS)
caps_vars = capitalization_teams(leet_vars)
nums_vars = add_nums(caps_vars)

print(f"Total variations: {len(nums_vars)}")

with open('nba_wordlist.txt', 'w') as f:
    for item in nums_vars:
        f.write(f"{item}\n")
