import sys

sizeCheck = 8


def main():
	inputSize = input("Enter a number: ")
	print("Recieved input is: ", inputSize)
	if (inputSize == sizeCheck):
		print("Hey it works")
	transitions = [
		[1,2,3 ],#start (empty)
		[4,5,6 ],#a
		[7,8,9 ],#b
		[10,11,12], #c
		[37,13,14], #aa
		[15,16,17], #ab
		[18,19,20], #ac
		[21,22,23], #ba
		[24,37,25], #bb
		[26,27,28], #bc
		[29,30,31], #ca
		[32,33,34], #cb
		[35,36,37], #cc
		[37,37,17], #aab
		[37,19,37], #aac
		[37,37,23], #aba
		[37,37,25], #abb
		[26,27,28], #abc
		[37,30,37], #aca
		[32,33,34], #acb
		[37,36,37], #acc
		[37,37,14], #baa
		[37,37,17], #bab
		[18,19,20], #bac
		[37,37,23], #bba
		[26,37,37], #bbc
		[29,30,31], #bca
		[32,37,37], #bcb
		[35,37,37], #bcc
		[37,13,37], #caa
		[15,16,17], #cab
		[37,19,37], #cac
		[21,22,23], #cba
		[24,37,37], #cbb
		[26,37,37], #cbc
		[37,30,37], #cca
		[32,37,37], #ccb
		[37,37,37] #dead
		]

	for x in transitions:
		print(x)

main()
